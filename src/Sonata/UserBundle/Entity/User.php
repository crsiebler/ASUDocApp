<?php

namespace Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity()
 */
class User extends BaseUser {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="user_roles",
     *                  joinColumns={@ORM\JoinColumn(name="userID", referencedColumnName="id")},
     *                  inverseJoinColumns={@ORM\JoinColumn(name="roleID", referencedColumnName="id")})
     */
    protected $userRoles;

    /**
     * @ORM\Column(name="firstName", type="string", length=75)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=75)
     */
    protected $lastName;

    public function addRole($role) {
        //make sure user doesn't already have the role
        $hasRole = false;

        foreach ($this->userRoles as $userRole) {
            if ($userRole == $role) {
                $hasRole = true;
            }
        }

        if (!$hasRole)
            $this->userRoles->add($role);

        return $this;
    }

    public function getRoles() {
        return $this->userRoles->toArray();
    }

    public function hasRole($role) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole == $role) {
                return true;
            }
        }

        return false;
    }

    public function hasRoleByName($role) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->getName() == $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function __construct() {
        parent::__construct();
        $this->userRoles = new ArrayCollection();
    }

    public function getUserRoles() {
        return $this->userRoles;
    }

    public function setUserRoles($userRoles) {
        $this->userRoles = $userRoles;
        return $this;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function __toString() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

}