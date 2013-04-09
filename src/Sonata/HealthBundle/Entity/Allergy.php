<?php

namespace Sonata\HealthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allergy
 *
 * @ORM\Table(name="allergies")
 * @ORM\Entity()
 */
class Allergy {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Sonata\UserBundle\Entity\User", inversedBy="allergies", fetch="EAGER")
     * @ORM\JoinColumn(name="patientID", referencedColumnName="id", nullable=false)
     */
    private $patient;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Allergy
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
        return $this;
    }
}
