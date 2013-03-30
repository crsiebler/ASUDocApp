<?php

namespace Sonata\HealthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrescriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('dateExpires')
                ->add('datePrescribed')
                ->add('frequency')
                ->add('dosage')
                ->add('name')
                ->add('reason')
                ->add('patient')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\HealthBundle\Entity\Prescription'
        ));
    }

    public function getName() {
        return 'sonata_healthbundle_prescriptiontype';
    }

}
