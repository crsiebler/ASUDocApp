<?php

namespace Sonata\AppointmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('note', "textarea", array(
                    'max_length' => 255,
                    'required' => true,
                    'label' => " ",
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\AppointmentBundle\Entity\Note'
        ));
    }

    public function getName() {
        return 'sonata_appointmentbundle_notetype';
    }

}
