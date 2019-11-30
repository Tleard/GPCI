<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Table(name="calendar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="begin_at")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="end_at")
     */
    private $endAt = null;

    /**
     * @ORM\Column(type="string", length=255, name="title", nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Courses")
     * @ORM\JoinColumn(nullable=true, name="course")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Room")
     * @ORM\JoinColumn(nullable=true, name="room")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true, name="supervisor")
     */
    private $supervisor;

    /**
     * @var boolean
     * @ORM\Column(nullable=true, name="unavailability")
     */
    private $unavailability;

    /**
     * @var string
     * @ORM\Column(nullable=true, name="color")
     */
    private $color;

    public function getId()
    {
        return $this->id;
    }

    public function getBeginAt()
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt)
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt()
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt = null)
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }



    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * @param mixed $supervisor
     */
    public function setSupervisor($supervisor): void
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course): void
    {
        $this->course = $course;
    }

    /**
     * @return bool
     */
    public function isUnavailability(): bool
    {
        return $this->unavailability;
    }

    /**
     * @param bool $unavailability
     */
    public function setUnavailability(bool $unavailability): void
    {
        $this->unavailability = $unavailability;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }


}