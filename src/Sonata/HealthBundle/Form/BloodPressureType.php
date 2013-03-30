<?php

namespace Sonata\HealthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BloodPressureType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('max')
                ->add('min')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\HealthBundle\Entity\BloodPressure'
        ));
    }

    public function getName() {
        return 'sonata_healthbundle_bloodpressuretype';
    }

}
