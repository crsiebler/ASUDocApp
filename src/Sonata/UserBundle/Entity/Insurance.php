<?php

namespace Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Insurance
 *
 * @ORM\Table(name="insurance")
 * @ORM\Entity()
 */
class Insurance {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=75)
     */
    private $name;

    /**
     * @ORM\Column(name="groupPolicy", type="string", length=12)
     */
    private $groupPolicy;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getGroupPolicy() {
        return $this->groupPolicy;
    }

    public function setGroupPolicy($groupPolicy) {
        $this->groupPolicy = $groupPolicy;
        return $this;
    }
}