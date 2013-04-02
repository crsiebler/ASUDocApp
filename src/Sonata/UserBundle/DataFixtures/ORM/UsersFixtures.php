<?php

namespace Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $_container;

    public function getOrder() {
        return 4;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $userManager = $this->_container->get('fos_user.user_manager');

        // Initialize Users for FOSUserBundle
        $user1 = $userManager->createUser();
        $user2 = $userManager->createUser();
        $user3 = $userManager->createUser();
        $user4 = $userManager->createUser();
        $user5 = $userManager->createUser();
        $user6 = $userManager->createUser();
        $user7 = $userManager->createUser();
        $user8 = $userManager->createUser();
        $user9 = $userManager->createUser();
        $user10 = $userManager->createUser();
        $user11 = $userManager->createUser();
        $user12 = $userManager->createUser();
        $user13 = $userManager->createUser();
        $user14 = $userManager->createUser();
        $user15 = $userManager->createUser();
        $user16 = $userManager->createUser();
        $user17 = $userManager->createUser();
        $user18 = $userManager->createUser();
        $user19 = $userManager->createUser();
        $user20 = $userManager->createUser();
        $user21 = $userManager->createUser();

        // Initialize Basic User information
        $user1->setFirstName('Cory')
                ->setLastName('Siebler')
                ->setUsername('csiebler@asu.edu')
                ->setEmail('csiebler@asu.edu')
                ->setPlainPassword('asucse360')
                ->setEnabled(true);

        $user2->setFirstName('Kyle')
                ->setLastName('Rota')
                ->setUsername('krota@asu.edu')
                ->setEmail('krota@asu.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user3->setFirstName('Bryan')
                ->setLastName('Garcia')
                ->setUsername('bryan.garcia@asu.edu')
                ->setEmail('bryan.garcia@asu.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user4->setFirstName('Peter')
                ->setLastName('Tinsley')
                ->setUsername('ptinsley@asu.edu')
                ->setEmail('ptinsley@asu.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user5->setFirstName('Ben')
                ->setLastName('Prather')
                ->setUsername('bprather@asu.edu')
                ->setEmail('bprather@asu.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user6->setFirstName('Test')
                ->setLastName('Patient')
                ->setUsername('patient@sonata.edu')
                ->setEmail('patient@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user7->setFirstName('Demo1')
                ->setLastName('Patient')
                ->setUsername('patient1@sonata.edu')
                ->setEmail('patient1@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user8->setFirstName('Demo2')
                ->setLastName('Patient')
                ->setUsername('patient2@sonata.edu')
                ->setEmail('patient2@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user9->setFirstName('Demo3')
                ->setLastName('Patient')
                ->setUsername('patient3@sonata.edu')
                ->setEmail('patient3@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user10->setFirstName('Demo4')
                ->setLastName('Patient')
                ->setUsername('patient4@sonata.edu')
                ->setEmail('patient4@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user11->setFirstName('Demo5')
                ->setLastName('Patient')
                ->setUsername('patient5@sonata.edu')
                ->setEmail('patient5@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user12->setFirstName('Test')
                ->setLastName('Doctor')
                ->setUsername('doctor@sonata.edu')
                ->setEmail('doctor@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user13->setFirstName('Demo1')
                ->setLastName('Doctor')
                ->setUsername('doctor1@sonata.edu')
                ->setEmail('doctor1@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user14->setFirstName('Demo2')
                ->setLastName('Doctor')
                ->setUsername('doctor2@sonata.edu')
                ->setEmail('doctor2@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user15->setFirstName('Demo3')
                ->setLastName('Doctor')
                ->setUsername('doctor3@sonata.edu')
                ->setEmail('doctor3@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user16->setFirstName('Test')
                ->setLastName('Nurse')
                ->setUsername('nurse@sonata.edu')
                ->setEmail('nurse@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user17->setFirstName('Demo1')
                ->setLastName('Nurse')
                ->setUsername('nurse1@sonata.edu')
                ->setEmail('nurse1@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user18->setFirstName('Demo2')
                ->setLastName('Nurse')
                ->setUsername('nurse2@sonata.edu')
                ->setEmail('nurse2@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user19->setFirstName('Demo3')
                ->setLastName('Nurse')
                ->setUsername('nurse3@sonata.edu')
                ->setEmail('nurse3@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user20->setFirstName('Test')
                ->setLastName('Office-Admin')
                ->setUsername('office-admin@sonata.edu')
                ->setEmail('office-admin@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        $user21->setFirstName('Test')
                ->setLastName('EMT')
                ->setUsername('emt@sonata.edu')
                ->setEmail('emt@sonata.edu')
                ->setPlainPassword('password')
                ->setEnabled(true);

        // Initialize User Roles
        $user1->getUserRoles()->add($this->getReference('role_user'));
        $user1->getUserRoles()->add($this->getReference('role_site_admin'));

        $user2->getUserRoles()->add($this->getReference('role_user'));
        $user2->getUserRoles()->add($this->getReference('role_site_admin'));

        $user3->getUserRoles()->add($this->getReference('role_user'));
        $user3->getUserRoles()->add($this->getReference('role_site_admin'));

        $user4->getUserRoles()->add($this->getReference('role_user'));
        $user4->getUserRoles()->add($this->getReference('role_site_admin'));

        $user5->getUserRoles()->add($this->getReference('role_user'));
        $user5->getUserRoles()->add($this->getReference('role_site_admin'));

        $user6->getUserRoles()->add($this->getReference('role_user'));
        $user6->getUserRoles()->add($this->getReference('role_patient'));

        $user7->getUserRoles()->add($this->getReference('role_user'));
        $user7->getUserRoles()->add($this->getReference('role_patient'));

        $user8->getUserRoles()->add($this->getReference('role_user'));
        $user8->getUserRoles()->add($this->getReference('role_patient'));

        $user9->getUserRoles()->add($this->getReference('role_user'));
        $user9->getUserRoles()->add($this->getReference('role_patient'));

        $user10->getUserRoles()->add($this->getReference('role_user'));
        $user10->getUserRoles()->add($this->getReference('role_patient'));

        $user11->getUserRoles()->add($this->getReference('role_user'));
        $user11->getUserRoles()->add($this->getReference('role_patient'));

        $user12->getUserRoles()->add($this->getReference('role_user'));
        $user12->getUserRoles()->add($this->getReference('role_doctor'));

        $user13->getUserRoles()->add($this->getReference('role_user'));
        $user13->getUserRoles()->add($this->getReference('role_doctor'));

        $user14->getUserRoles()->add($this->getReference('role_user'));
        $user14->getUserRoles()->add($this->getReference('role_doctor'));

        $user15->getUserRoles()->add($this->getReference('role_user'));
        $user15->getUserRoles()->add($this->getReference('role_doctor'));

        $user16->getUserRoles()->add($this->getReference('role_user'));
        $user16->getUserRoles()->add($this->getReference('role_nurse'));

        $user17->getUserRoles()->add($this->getReference('role_user'));
        $user17->getUserRoles()->add($this->getReference('role_nurse'));

        $user18->getUserRoles()->add($this->getReference('role_user'));
        $user18->getUserRoles()->add($this->getReference('role_nurse'));

        $user19->getUserRoles()->add($this->getReference('role_user'));
        $user19->getUserRoles()->add($this->getReference('role_nurse'));

        $user20->getUserRoles()->add($this->getReference('role_user'));
        $user20->getUserRoles()->add($this->getReference('role_admin'));

        $user21->getUserRoles()->add($this->getReference('role_user'));
        $user21->getUserRoles()->add($this->getReference('role_emt'));

        // Initialize User References for relationship mapping
        $this->setReference('user_csiebler', $user1);
        $this->setReference('user_krota', $user2);
        $this->setReference('user_bgarcia', $user3);
        $this->setReference('user_ptinsley', $user4);
        $this->setReference('user_bprather', $user5);
        $this->setReference('user_patient', $user6);
        $this->setReference('user_patient1', $user7);
        $this->setReference('user_patient2', $user8);
        $this->setReference('user_patient3', $user9);
        $this->setReference('user_patient4', $user10);
        $this->setReference('user_patient5', $user11);
        $this->setReference('user_doctor', $user12);
        $this->setReference('user_doctor1', $user13);
        $this->setReference('user_doctor2', $user14);
        $this->setReference('user_doctor3', $user15);
        $this->setReference('user_nurse', $user16);
        $this->setReference('user_nurse1', $user17);
        $this->setReference('user_nurse2', $user18);
        $this->setReference('user_nurse3', $user19);
        $this->setReference('user_admin', $user20);
        $this->setReference('user_emt', $user21);

        // Update User in FOSUserBundle
        $userManager->updateUser($user1);
        $userManager->updateUser($user2);
        $userManager->updateUser($user3);
        $userManager->updateUser($user4);
        $userManager->updateUser($user5);
        $userManager->updateUser($user6);
        $userManager->updateUser($user7);
        $userManager->updateUser($user8);
        $userManager->updateUser($user9);
        $userManager->updateUser($user10);
        $userManager->updateUser($user11);
        $userManager->updateUser($user12);
        $userManager->updateUser($user13);
        $userManager->updateUser($user14);
        $userManager->updateUser($user15);
        $userManager->updateUser($user16);
        $userManager->updateUser($user17);
        $userManager->updateUser($user18);
        $userManager->updateUser($user19);
        $userManager->updateUser($user20);
        $userManager->updateUser($user21);

        $manager->flush();
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->_container = $container;
    }

}

?>