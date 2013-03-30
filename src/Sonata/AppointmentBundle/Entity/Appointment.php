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
}
