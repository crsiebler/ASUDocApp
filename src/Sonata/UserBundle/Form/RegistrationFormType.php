<?php

namespace Sonata\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        $builder->add('firstName', null, array(
                    'max_length' => 75,
                    'required' => true,
                    'label' => 'First Name:',
                    'trim' => true,
                ))
                ->add('lastName', null, array(
                    'max_length' => 75,
                    'required' => true,
                    'label' => 'Last Name:',
                    'trim' => true,
                ))
                ->add('userRoles', 'entity', array(
                    'class' => 'SonataUserBundle:Role',
                    'property' => 'displayName',
                    'required' => true,
                    'label' => 'User Role:',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                                  ->select('r')
                                  ->where('r.name NOT LIKE :standardUser')
                                  ->andWhere('r.name NOT LIKE :superAdmin')
                                  ->orderBy('r.displayName', 'ASC')
                                  ->setParameter('standardUser', 'ROLE_USER')
                                  ->setParameter('superAdmin', 'ROLE_SITE-ADMIN');
                    }
                ))
                ->remove('username')
                ->remove('plainPassword');
    }

    public function getName() {
        return 'sonata_user_registration';
    }

}