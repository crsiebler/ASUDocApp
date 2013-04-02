<?php

namespace Sonata\AppointmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AppointmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('dateOf')
                ->add('weight')
                ->add('height')
                ->add('glucose')
                ->add('bloodPressure')
                ->add('note');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\AppointmentBundle\Entity\Appointment'
        ));
    }

    public function getName() {
        return 'sonata_appointmentbundle_appointmenttype';
    }

}
