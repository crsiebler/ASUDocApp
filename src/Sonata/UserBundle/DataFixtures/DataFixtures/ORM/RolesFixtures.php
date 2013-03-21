<?php

namespace Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Sonata\UserBundle\Entity\Role;

class RolesFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 1;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $role1 = new Role();
        $role1->setName('user')
                ->setDisplayName('Standard User')
                ->setDescription('Role for standard user level access.');

        $role2 = new Role();
        $role2->setName('admin')
                ->setDisplayName('Admin User')
                ->setDescription('User that has the ability access the Admin site.');

        $manager->persist($role1);
        $manager->persist($role2);

        $this->setReference('role_user', $role1);
        $this->setReference('role_admin', $role2);

        $manager->flush();
    }
}

?>