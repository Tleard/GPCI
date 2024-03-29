<?php

declare(strict_types=1);

namespace CalendarBundle\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Room;
use AppBundle\Entity\User;

class Event
{
    const DATE_FORMAT = 'Y-m-d\\TH:i:s.u\\Z';

    /**
     * @var string
     */
    protected $title;

    /**
     * @var DateTimeInterface
     */
    protected $start;

    /**
     * @var DateTimeInterface|null
     */
    protected $end;

    /**
     * @var bool
     */
    protected $allDay = true;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $color;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Room", mappedBy="id", fetch="LAZY")
     */
    protected $room;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="id", fetch="LAZY")
     */
    protected $supervisor;

    public function __construct(
        string $title,
        DateTimeInterface $start,
        ?DateTimeInterface $end = null,
        string $color,
        Room $room,
        User $supervisor,
        array $options = []
    ) {
        $this->setTitle($title);
        $this->setStart($start);
        $this->setEnd($end);
        $this->setColor($color);
        $this->setRoom($room);
        $this->setSupervisor($supervisor);
        $this->setOptions($options);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStart(): ?DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(DateTimeInterface $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): ?DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?DateTimeInterface $end): void
    {
        if (null !== $end) {
            $this->allDay = false;
        }
        $this->end = $end;
    }

    public function isAllDay(): bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): void
    {
        $this->allDay = $allDay;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
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


    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room): void
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
     * @param string|int $name
     */
    public function getOption($name)
    {
        return $this->options[$name];
    }

    /**
     * @param string|int $name
     */
    public function addOption($name, $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * @param string|int $name
     *
     * @return mixed|null
     */
    public function removeOption($name)
    {
        if (!isset($this->options[$name]) && !\array_key_exists($name, $this->options)) {
            return null;
        }

        $removed = $this->options[$name];
        unset($this->options[$name]);

        return $removed;
    }

    public function toArray(): array
    {
        $event = [
            'title' =>$this->getTitle() . "\n" . "\n" . "\n" ."Salle : " .$this->getRoom()->getName() .
            "\n Professeur : " . $this->getSupervisor()->getFirstName() . " " . $this->getSupervisor()->getLastName(),
            'start' => $this->getStart()->format(self::DATE_FORMAT),
            'color' => $this->getColor(),
            'supervisor' => $this->getSupervisor()->getFirstName(),
            'room' => $this->getRoom()->getName(),
            'allDay' => $this->isAllDay(),
        ];


        if (null !== $this->getEnd()) {
            $event['end'] = $this->getEnd()->format(self::DATE_FORMAT);
        }

        return array_merge($event, $this->getOptions());
    }
}
