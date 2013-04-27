<?php

namespace Sonata\AppointmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\HealthBundle\Form\BloodPressureType;

class PressureType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('bloodPressure', new BloodPressureType(), array(
                    'label' => "Blood Pressure",
                    'required' => true,
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\AppointmentBundle\Entity\Appointment',
            'cascade_validation' => true,
        ));
    }

    public function getName() {
        return 'sonata_appointmentbundle_pressuretype';
    }

}