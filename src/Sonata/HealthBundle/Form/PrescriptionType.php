<?php

namespace Sonata\HealthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrescriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array(
                    'label' => "Name:",
                    'required' => true,
                ))
                ->add('dateExpires', null, array(
                    'label' => "Expiration:",
                    'required' => false,
                ))
                ->add('frequency', null, array(
                    'label' => "Frequency of Use:",
                    'required' => true,
                ))
                ->add('dosage', null, array(
                    'label' => "Dosage:",
                    'required' => true,
                ))
                ->add('reason', null, array(
                    'label' => "Reason:",
                    'required' => false,
                ));
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
