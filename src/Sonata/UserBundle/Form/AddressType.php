<?php

namespace Sonata\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Check to see if Patient already has Address Information
        // If not use Country and State from Controller for Preferred Choices
        $prefCountry = $options['prefCountry'];
        
        if ($options['data'] !== null) {
            $country = $options['data']->getCountry();
        } else {
            $country = null;
        }

        $builder->add('address', null, array(
                    'label' => 'Address:'
                ))
                ->add('address2', null, array(
                    'label' => "Address (line 2):"
                ))
                ->add('city', null, array(
                    'label' => 'City:'
                ))
                ->add('country', 'entity', array(
                    'class' => 'SonataUserBundle:Country',
                    'label' => 'Country:',
                    'property' => 'name',
                    'required' => true,
                    'empty_value' => 'Please select a country',
                    'preferred_choices' => (isset($prefCountry)) ? array($prefCountry):array(),
                ))
                ->add('state', 'entity', array(
                    'class' => 'SonataUserBundle:State',
                    'property' => 'name',
                    'empty_value' => 'Please select a state',
                    'required' => false,
                    'disabled' => (isset($country) && $country->getStates()->isEmpty()) ? false:true,
                    'query_builder' => function ($repository) use ($country) {
                        $queryBuilder = $repository->createQueryBuilder('s')->select('s');

                        if (isset($country)) {
                            $queryBuilder->where('s.country = :country')
                                         ->setParameter('country', $country);
                        }

                        return $queryBuilder;
                    },
                    'read_only' => false,
                    'label' => 'State/Providence:',
                ))
                ->add('zipcode', null, array(
                    'label' => 'Zipcode:',
                    'required' => ($country->getZipCodeRequired()) ? true:false,
                ))
                ->add('phoneNumber', null, array(
                    'label' => 'Phone number:',
                    'required' => true,
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\UserBundle\Entity\Address',
            'prefCountry' => null,
        ));
    }

    public function getName() {
        return 'addressForm';
    }
    
}