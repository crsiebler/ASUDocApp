<?php

namespace Sonata\AppointmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="notes")
 * @ORM\Entity()
 */
class Note {

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
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\OneToOne(targetEntity="Users")
     */
    private $createBy;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Note
     */
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Note
     */
    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getCreateBy() {
        return $this->createBy;
    }

    public function setCreateBy($createBy) {
        $this->createBy = $createBy;
        return $this;
    }
}
