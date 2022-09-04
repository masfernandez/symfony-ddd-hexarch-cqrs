<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\DomainEvent;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\AsyncEvent;

final class AlbumCreatedDomainEvent extends DomainEvent implements AsyncEvent
{
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $release_date,
        string $eventId = null,
        string $eventDate = null
    ) {
        parent::__construct($id, $eventId, $eventDate);
    }

    public static function fromPrimitives(string $aggregateId, array $data, string $eventId, string $eventDate): self
    {
        return new self(
            $aggregateId,
            $data[Album::TITLE],
            $data[Album::RELEASE_DATE],
            $eventId,
            $eventDate
        );
    }

    /**
     * @return array<string, string>
     */
    public function toPrimitives(): array
    {
        return [
            Album::ID              => $this->id,
            Album::TITLE           => $this->title,
            Album::RELEASE_DATE => $this->release_date
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPublishingDate(): string
    {
        return $this->release_date;
    }

    public static function eventName(): string
    {
        // @todo
        return '';
    }
}
