<?php

namespace ClassicAirAviation\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use ClassicAirAviation\UserBundle\Entity\Role;

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

        $role3 = new Role();
        $role3->setName('flight_instructor')
                ->setDisplayName('Flight Instructor')
                ->setDescription('User that is a flight instructor within the company. This allows a user to perform flight instructor type operations.');

        $role4 = new Role();
        $role4->setName('location_admin')
                ->setDisplayName('Location Administrator')
                ->setDescription('User that can change settings about a location. This applies to all locations the user is assigned to.');

        $role6 = new Role();
        $role6->setName('company_admin')
                ->setDisplayName('Company Administrator')
                ->setDescription('User that can change settings about a company.');

        $role5 = new Role();
        $role5->setName('scheduler')
                ->setDisplayName('Scheduler')
                ->setDescription('User that is allowed to set the "event with" to another user other than themselves.');


        $manager->persist($role1);
        $manager->persist($role2);
        $manager->persist($role3);
        $manager->persist($role4);
        $manager->persist($role5);
        $manager->persist($role6);

        $this->setReference('role_user', $role1);
        $this->setReference('role_admin', $role2);
        $this->setReference('role_flight_instructor', $role3);
        $this->setReference('role_location_admin', $role4);
        $this->setReference('role_company_admin', $role6);

        $manager->flush();
    }

}

?>