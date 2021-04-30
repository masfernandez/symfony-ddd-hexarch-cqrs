<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\Bus\Event;

use DateTime;
use Symfony\Component\Uid\Uuid;

abstract class DomainEvent
{
    public static string $dateFormat = 'Y-m-d H:i:s';
    private string $eventId;
    private string $eventDate;

    public function __construct(private string $aggregateId, string $eventId = null, string $eventDate = null)
    {
        $this->eventId   = $eventId ?: Uuid::v4()->toRfc4122();
        $this->eventDate = $eventDate ?: (new DateTime())->format(self::$dateFormat);
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
