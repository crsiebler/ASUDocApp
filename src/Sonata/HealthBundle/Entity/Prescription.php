<?php

namespace Sonata\HealthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prescription
 *
 * @ORM\Table(name="prescriptions")
 * @ORM\Entity()
 */
class Prescription {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExpires", type="date", nullable=true)
     */
    private $dateExpires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePrescribed", type="date")
     */
    private $datePrescribed;

    /**
     * @var string
     *
     * @ORM\Column(name="frequency", type="string", length=64)
     */
    private $frequency;

    /**
     * @var string
     *
     * @ORM\Column(name="dosage", type="string", length=64)
     */
    private $dosage;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255, nullable=true)
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity="Sonata\UserBundle\Entity\User", inversedBy="prescriptions", fetch="EAGER")
     * @ORM\JoinColumn(name="patientID", referencedColumnName="id", nullable=false)
     */
    private $patient;
    
    public function __construct() {
        $this->dateExpires = null;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateExpires
     *
     * @param \DateTime $dateExpires
     * @return Prescription
     */
    public function setDateExpires($dateExpires) {
        $this->dateExpires = $dateExpires;
        return $this;
    }

    /**
     * Get dateExpires
     *
     * @return \DateTime
     */
    public function getDateExpires() {
        return $this->dateExpires;
    }

    /**
     * Set datePrescribed
     *
     * @param \DateTime $datePrescribed
     * @return Prescription
     */
    public function setDatePrescribed($datePrescribed) {
        $this->datePrescribed = $datePrescribed;
        return $this;
    }

    /**
     * Get datePrescribed
     *
     * @return \DateTime
     */
    public function getDatePrescribed() {
        return $this->datePrescribed;
    }

    /**
     * Set frequency
     *
     * @param string $frequency
     * @return Prescription
     */
    public function setFrequency($frequency) {
        $this->frequency = $frequency;
        return $this;
    }

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency() {
        return $this->frequency;
    }

    /**
     * Set dosage
     *
     * @param string $dosage
     * @return Prescription
     */
    public function setDosage($dosage) {
        $this->dosage = $dosage;
        return $this;
    }

    /**
     * Get dosage
     *
     * @return string
     */
    public function getDosage() {
        return $this->dosage;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Prescription
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return Prescription
     */
    public function setReason($reason) {
        $this->reason = $reason;
        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason() {
        return $this->reason;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
        return $this;
    }
}