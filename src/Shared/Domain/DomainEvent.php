<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Shared\Domain;

use DateTime;
use Symfony\Component\Uid\Uuid;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $eventDate;

    public function __construct(
        private readonly string $aggregateId,
        string $eventId = null,
        string $eventDate = null
    ) {
        $this->eventId   = $eventId ?: Uuid::v4()->toRfc4122();
        $this->eventDate = $eventDate ?: (new DateTime())->format(DATE_W3C);
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $data,
        string $eventId,
        string $eventDate
    ): self;

    /**
     * @return mixed[]
     */
    abstract public function toPrimitives(): array;

    abstract public static function eventName(): string;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->eventDate;
    }
}
