<?php

namespace Sonata\AppointmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Sonata\HealthBundle\Form\BloodPressureType;
use Sonata\AppointmentBundle\Form\NoteType;

class AppointmentType extends AbstractType {

    public function __construct(SecurityContext $securityContext) {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('weight', null, array(
                    'required' => true,
                    'label' => "Weight (kg):",
                    'precision' => 1,
                ))
                ->add('height', null, array(
                    'required' => true,
                    'label' => "Height (cm):",
                ))
                ->add('glucose', null, array(
                    'required' => false,
                    'label' => "Blood Glucose (mg/dl):",
                ))
                ->add('bloodPressure', new BloodPressureType(), array(
                    'label' => "Blood Pressure",
                    'required' => true,
                ));
        
        $user = $this->securityContext->getToken()->getUser();
        
        if ($user->hasRoleByName('ROLE_DOCTOR')) {
            $builder->add('note', new NoteType(), array(
                        'label' => "Doctors Note:",
                        'required' => true,
            ));
        }
        
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sonata\AppointmentBundle\Entity\Appointment',
            'cascade_validation' => true,
        ));
    }

    public function getName() {
        return 'sonata_appointmentbundle_appointmenttype';
    }

}