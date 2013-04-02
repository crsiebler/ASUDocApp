<?php

namespace Sonata\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // initialize country to null if the order is unable to pull the address information
        // key relationship may be damaged from cloning the original database
        if ($options['data'] != null) {
            $country = $options['data']->getCountry();
        } else {
            $country = null;
        }

        $builder->add('firstName', null, array(
                    'label' => "First name:"
                ))
                ->add('lastName', null, array(
                    'label' => 'Last name:'
                ))
                ->add('phoneNumber', null, array(
                    'label' => 'Phone number:'
                ))
                ->add('address', null, array(
                    'label' => 'Address:'
                ))
                ->add('address2', null, array(
                    'label' => "Address (line 2):"
                ))
                ->add('city', null, array(
                    'label' => 'City:'
                ))
                ->add('country', 'entity', array(
                    'class' => 'GhostArmorUserBundle:Country',
                    'label' => 'Country',
                    'required' => true,
                    'empty_value' => 'Please select a country',
                ))
                ->add('state', 'entity', array(
                    'class' => 'GhostArmorUserBundle:State',
                    'empty_value' => 'Please select a state',
                    'required' => false,
                    'query_builder' => function ($repository) use ($country) {
                        $queryBuilder = $repository->createQueryBuilder('s')
                                ->select('s');

                        if ($country != null) {
                            $queryBuilder->where('s.country = :country')
                            ->setParameter("country", $country);
                        }

                        return $queryBuilder;
                    },
                    'read_only' => false,
                    'label' => 'State/Providence:',
                ))
                ->add('zipcode', null, array(
                    'label' => 'Zipcode:'
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\UserBundle\Entity\Address'
        ));
    }

    public function getName() {
        return 'sonata_userbundle_addresstype';
    }

}
