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
     * @ORM\Column(type="string", length=255, name="title")
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Classe")
     * @ORM\JoinColumn(nullable=true, name="class")
     */
    private $class;

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
     * @return Classe
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param Classe $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }


}