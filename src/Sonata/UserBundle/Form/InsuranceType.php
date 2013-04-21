<?php

namespace Sonata\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InsuranceType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array(
                    'label' => "Name:",
                    'required' => true,
                ))
                ->add('groupPolicy', null, array(
                    'label' => "Group Policy:",
                    'required' => true,
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\UserBundle\Entity\Insurance'
        ));
    }

    public function getName() {
        return 'sonata_userbundle_insurancetype';
    }

}
