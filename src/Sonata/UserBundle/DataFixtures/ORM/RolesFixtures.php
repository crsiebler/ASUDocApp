<?php

namespace Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Sonata\UserBundle\Entity\Role;

class RolesFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 3;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $role1 = new Role();
        $role1->setName('user')
                ->setDisplayName('Standard User')
                ->setDescription('Role for standard user level access.');

        $role2 = new Role();
        $role2->setName('site-admin')
                ->setDisplayName('Website Admin')
                ->setDescription('User has ability to modify any information on the website.');

        $role3 = new Role();
        $role3->setName('patient')
                ->setDisplayName('Patient')
                ->setDescription('Doctor\'s office patient.');

        $role4 = new Role();
        $role4->setName('doctor')
                ->setDisplayName('Doctor')
                ->setDescription('Role for Doctor level access.');

        $role5 = new Role();
        $role5->setName('nurse')
                ->setDisplayName('Nurse')
                ->setDescription('Role for Nurse level access.');

        $role6 = new Role();
        $role6->setName('admin')
                ->setDisplayName('Office Admin')
                ->setDescription('Role for Office Admin level access.');

        $role7 = new Role();
        $role7->setName('emt')
                ->setDisplayName('EMT')
                ->setDescription('Role for EMT level access.');

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->persist($role3);
        $manager->persist($role4);
        $manager->persist($role5);
        $manager->persist($role6);
        $manager->persist($role7);

        $this->setReference('role_user', $role1);
        $this->setReference('role_site_admin', $role2);
        $this->setReference('role_patient', $role3);
        $this->setReference('role_doctor', $role4);
        $this->setReference('role_nurse', $role5);
        $this->setReference('role_admin', $role6);
        $this->setReference('role_emt', $role7);

        $manager->flush();
    }
}

?>