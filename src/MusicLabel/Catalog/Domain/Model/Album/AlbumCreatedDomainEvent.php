<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\Shared\Domain\Bus\Event\AsyncEventInterface;
use Masfernandez\Shared\Domain\Bus\Event\DomainEventAbstract;

final class AlbumCreatedDomainEvent extends DomainEventAbstract implements AsyncEventInterface
{
    public function __construct(
        private string $id,
        private string $title,
        private string $publishing_date,
        string $eventId = null,
        string $eventDate = null
    )
    {
        parent::__construct($id, $eventId, $eventDate);
    }

    public static function fromPrimitives(string $aggregateId, array $data, string $eventId, string $eventDate): self
    {
        return new self(
            $aggregateId,
            $data[Album::TITLE],
            $data[Album::PUBLISHING_DATE],
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
            Album::ID => $this->id,
            Album::TITLE => $this->title,
            Album::PUBLISHING_DATE => $this->publishing_date
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
        return $this->publishing_date;
    }
}
