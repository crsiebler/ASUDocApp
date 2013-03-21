<?php

namespace Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $_container;

    public function getOrder() {
        return 5;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $userManager = $this->_container->get('fos_user.user_manager');

        $user1 = $userManager->createUser();

        $user1->setFirstName('Cory')
                ->setLastName('Siebler')
                ->setEmail('csiebler@asu.edu')
                ->setPlainPassword('softball854')
                ->setEnabled(true)
                ->setUsername('csiebler');


        $user1->getUserRoles()->add($this->getReference('role_user'));
        $user1->getUserRoles()->add($this->getReference('role_admin'));

        $this->setReference('admin_user', $user1);

        $userManager->updateUser($user1);

        $manager->flush();
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->_container = $container;
    }

}

?>