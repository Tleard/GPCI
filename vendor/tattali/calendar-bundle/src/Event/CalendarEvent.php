<?php

declare(strict_types=1);

namespace CalendarBundle\Event;

use CalendarBundle\Entity\Event;
use CalendarBundle\Event\Event as BaseEvent;
use DateTimeInterface;
use AppBundle\Entity\Room;

/**
 * This event is triggered before the serialization of the events.
 *
 * This event allows you to fill the calendar with your data.
 */
class CalendarEvent extends BaseEvent
{
    /**
     * @var DateTimeInterface
     */
    protected $start;

    /**
     * @var DateTimeInterface
     */
    protected $end;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $room;

    /**
     * @var Event[]
     */
    protected $events = [];

    public function __construct(
        DateTimeInterface $start,
        DateTimeInterface $end,
        array $filters,
        $color,
        $room
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->filters = $filters;
        $this->color = $color;
        $this->room = $room;
    }

    public function getStart(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd(): DateTimeInterface
    {
        return $this->end;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom(string $room): void
    {
        $this->room = $room;
    }


    public function addEvent(Event $event): self
    {
        if (!\in_array($event, $this->events, true)) {
            $this->events[] = $event;
        }

        return $this;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
