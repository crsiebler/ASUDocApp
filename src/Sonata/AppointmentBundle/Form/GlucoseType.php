<?php

namespace Sonata\AppointmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GlucoseType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('glucose', null, array(
                    'required' => true,
                    'label' => "Blood Glucose (mg/dl):",
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\AppointmentBundle\Entity\Appointment',
        ));
    }

    public function getName() {
        return 'sonata_appointmentbundle_glucosetype';
    }

}