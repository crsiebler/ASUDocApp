<?php

namespace Sonata\AppointmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 *
 * @ORM\Table(name="appointments")
 * @ORM\Entity(repositoryClass="Sonata\AppointmentBundle\Repository\AppointmentRepository")
 */
class Appointment {

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
     * @ORM\Column(name="dateOf", type="datetime")
     */
    private $dateOf;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="inOffice", type="boolean", nullable=false)
     */
    private $inOffice;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal")
     */
    private $weight;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var integer
     *
     * @ORM\Column(name="glucose", type="integer")
     */
    private $glucose;

    /**
     * @ORM\OneToOne(targetEntity="Sonata\HealthBundle\Entity\BloodPressure", inversedBy="appointment", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="bp_id", referencedColumnName="id", nullable=true, unique=true)
     */
    private $bloodPressure;

    /**
     * @ORM\OneToOne(targetEntity="Sonata\AppointmentBundle\Entity\Note", inversedBy="appointment", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="note_id", referencedColumnName="id", nullable=true, unique=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Sonata\UserBundle\Entity\User", inversedBy="appointments", fetch="EAGER")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id", nullable=false, unique=false)
     */
    private $patient;
    
    public function __construct($inOffice) {
        $this->dateOf = new \DateTime('now');
        $this->inOffice = $inOffice;
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
     * Set dateOf
     *
     * @param \DateTime $dateOf
     * @return Appointment
     */
    public function setDateOf($dateOf) {
        $this->dateOf = $dateOf;
        return $this;
    }

    /**
     * Get dateOf
     *
     * @return \DateTime
     */
    public function getDateOf() {
        return $this->dateOf;
    }

    public function getInOffice() {
        return $this->inOffice;
    }

    public function setInOffice($inOffice) {
        $this->inOffice = $inOffice;
        return $this;
    }
    
    /**
     * Set weight
     *
     * @param float $weight
     * @return Appointment
     */
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Appointment
     */
    public function setHeight($height) {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Set glucose
     *
     * @param integer $glucose
     * @return Appointment
     */
    public function setGlucose($glucose) {
        $this->glucose = $glucose;
        return $this;
    }

    /**
     * Get glucose
     *
     * @return integer
     */
    public function getGlucose() {
        return $this->glucose;
    }

    /**
     *
     * @return type
     */
    public function getBloodPressure() {
        return $this->bloodPressure;
    }

    /**
     *
     * @param type $bloodPressure
     * @return \Sonata\AppointmentBundle\Entity\Appointment
     */
    public function setBloodPressure($bloodPressure) {
        $this->bloodPressure = $bloodPressure;
        return $this;
    }

    /**
     *
     * @return type
     */
    public function getNote() {
        return $this->note;
    }

    /**
     *
     * @param type $note
     * @return \Sonata\AppointmentBundle\Entity\Appointment
     */
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
        return $this;
    }
}
