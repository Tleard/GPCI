<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @ORM\Table(name="week")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeekRepository")
 */
class Week
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="year", type="datetime")
     */
    private $year;

    /**
     * @var bool
     *
     * @ORM\Column(name="vacancy", type="boolean")
     */
    private $vacancy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set year
     *
     * @param \DateTime $year
     *
     * @return Week
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set vacancy
     *
     * @param boolean $vacancy
     *
     * @return Week
     */
    public function setVacancy($vacancy)
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    /**
     * Get vacancy
     *
     * @return bool
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Week
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

