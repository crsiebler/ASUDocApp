<?php

namespace Sonata\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Check to see if Patient already has Address Information
        // If not use Country and State from Controller for Preferred Choices
        if ($options['data']->getId() != null) {
            $country = $options['data']->getCountry();
            $state = $options['state'];
        } elseif (isset($options['country']) && isset($options['state'])) {
            $country = $options['country'];
            $state = $options['state'];
        } elseif (isset($options['country']) && !isset($options['state'])) {
            $country = $options['country'];
            $state = null;
        } else {
            $country = null;
            $state = null;
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
                    'label' => 'Country',
                    'required' => true,
                    'empty_value' => 'Please select a country',
                    'preferred_choices' => (isset($country)) ? array($country):array(),
                ))
                ->add('state', 'entity', array(
                    'class' => 'SonataUserBundle:State',
                    'empty_value' => 'Please select a state',
                    'required' => false,
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
                    'preferred_choices' => (isset($state)) ? array($state):array(),
                ))
                ->add('zipcode', null, array(
                    'label' => 'Zipcode:'
                ))
                ->add('phoneNumber', null, array(
                    'label' => 'Phone number:'
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\UserBundle\Entity\Address',
            'country' => null,
            'state' => null,
        ));
    }

    public function getName() {
        return 'addressForm';
    }
    
}
