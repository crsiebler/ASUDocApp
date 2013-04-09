<?php

namespace Sonata\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sonata\UserBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity()
 */
class Role implements RoleInterface {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(name="displayName", type="string", length=255)
     * @var string $name
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var type
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="Sonata\UserBundle\Entity\User", mappedBy="userRoles")
     */
    protected $users;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->getName();
    }

    public function setName($name) {
        $name = str_replace(' ', '_', strtoupper($name));

        if (substr($name, 0, 5) != "ROLE_") {
            $name = 'ROLE_' . $name;
        }

        $this->name = $name;
        return $this;
    }

    function __construct() {

    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getUsers() {
        return $this->users;
    }

    public function __toString() {
        return $this->getRole();
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

}