<?php

namespace ClassicAirAviation\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use ClassicAirAviation\UserBundle\Entity\Company;

class CompanyFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 2;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $company1 = new Company();
        $company2 = new Company();
        
        $company1->setName('Classic Air Aviation');
        
        $company2->setName('CAF');
        
        $manager->persist($company1);
        $manager->persist($company2);
        
        $this->setReference('company1', $company1);
        $this->setReference('company2', $company2);
        
        $manager->flush();
    }
}

?>