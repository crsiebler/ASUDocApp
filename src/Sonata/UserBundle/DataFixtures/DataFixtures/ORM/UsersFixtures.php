<?php

namespace ClassicAirAviation\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use ClassicAirAviation\FlightSchoolBundle\Entity\FlightInstructorPreference;
use ClassicAirAviation\SchedulerBundle\Entity\Hours;
use Doctrine\Common\Collections\ArrayCollection;

class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $_container;

    public function getOrder() {
        return 5;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $userManager = $this->_container->get('fos_user.user_manager');

        $user1 = $userManager->createUser();

        $user1->setFirstName('Kaelin')
                ->setLastName('Jacobson')
                ->setEmail('kaelinjacobson@gmail.com')
                ->setPlainPassword('Mrs._Kitty')
                ->setCompany($this->getReference('company1'))
                ->setEnabled(true)
                ->setUsername('Demoboy')
                ->setDefaultLocation($this->getReference('location1'))
                ->getAssignedLocations()->add($this->getReference('location1'));

        $user1->getAssignedLocations()->add($this->getReference('location3'));

        $user1->getUserRoles()->add($this->getReference('role_user'));
        $user1->getUserRoles()->add($this->getReference('role_admin'));
        $user1->getUserRoles()->add($this->getReference('role_location_admin'));
        $user1->getUserRoles()->add($this->getReference('role_company_admin'));
        
        $user2 = $userManager->createUser();

        $user2->setFirstName('Aaron')
                ->setLastName('Grissum')
                ->setEmail('testing123@gmail.com')
                ->setPlainPassword('Mrs._Kitty')
                ->setCompany($this->getReference('company1'))
                ->setEnabled(true)
                ->setUsername('BK')
                ->getAssignedLocations()->add($this->getReference('location1'));

        $hours1 = new ArrayCollection();
        $hours2 = new ArrayCollection();

        for ($i = 0; $i <= 6; $i++) {
            $hour1 = new Hours();
            $hour2 = new Hours();

            $hour1->setDayOfWeek($i)
                    ->setEnd(new \DateTime('7pm'))
                    ->setStart(new \DateTime('10am'));



            $hour2->setDayOfWeek($i)
                    ->setEnd(new \DateTime('6pm'))
                    ->setStart(new \DateTime('9am'));

            $hours1->add($hour1);
            $hours2->add($hour2);
        }

        $flightInstructorPreference1 = new FlightInstructorPreference();

        $flightInstructorPreference1->setAvailability($hours1)
                ->setColorScheme($this->getReference('orange'))
                ->setUser($user2);

        $user2->getUserRoles()->add($this->getReference('role_user'));
        $user2->getUserRoles()->add($this->getReference('role_flight_instructor'));

        $user3 = $userManager->createUser();

        $user3->setFirstName('Jon')
                ->setLastName('Marple')
                ->setEmail('testing1234@gmail.com')
                ->setPlainPassword('Mrs._Kitty')
                ->setCompany($this->getReference('company1'))
                ->setEnabled(true)
                ->setUsername('Joker')
                ->getAssignedLocations()->add($this->getReference('location1'));

        $user3->getAssignedLocations()->add($this->getReference('location3'));

        $user3->getUserRoles()->add($this->getReference('role_user'));
        $user3->getUserRoles()->add($this->getReference('role_flight_instructor'));

        $flightInstructorPreference2 = new FlightInstructorPreference();

        $flightInstructorPreference2->setAvailability($hours2)
                ->setColorScheme($this->getReference('red'))
                ->setUser($user3);

        $this->setReference('admin_user', $user1);
        $this->setReference('flight_instructor_user', $user2);
        $this->setReference('jon', $user3);
        
        $userManager->updateUser($user1);
        $userManager->updateUser($user2);
        $userManager->updateUser($user3);

        $manager->persist($flightInstructorPreference1);
        $manager->persist($flightInstructorPreference2);

        $manager->flush();
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->_container = $container;
    }

}

?>