<?php

namespace Sonata\HealthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BloodPressure
 *
 * @ORM\Table(name="bloodpressure")
 * @ORM\Entity(repositoryClass="Sonata\HealthBundle\Repository\BloodPressureRepository")
 */
class BloodPressure {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var integer
     *
     * @ORM\Column(name="min", type="integer")
     */
    private $min;
    
    /**
     * @ORM\OneToOne(targetEntity="Sonata\AppointmentBundle\Entity\Appointment", mappedBy="bloodPressure")
     */
    private $appointment;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set max
     *
     * @param integer $max
     * @return BloodPressure
     */
    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    /**
     * Get max
     *
     * @return integer
     */
    public function getMax() {
        return $this->max;
    }

    /**
     * Set min
     *
     * @param integer $min
     * @return BloodPressure
     */
    public function setMin($min) {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer
     */
    public function getMin() {
        return $this->min;
    }
    
    public function getAppointment() {
        return $this->appointment;
    }

    public function setAppointment($appointment) {
        $this->appointment = $appointment;
        return $this;
    }
}
