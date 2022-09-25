<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\ValueObject\TrackName;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\ValueObject\TrackPrice;
use Masfernandez\MusicLabel\Shared\Domain\AggregateRoot;
use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;
use Stringable;

class Track extends AggregateRoot implements Stringable
{
    private function __construct(
        private TrackId $id,
        private TrackName $name,
        private TrackPrice $price,
    ) {
    }

    public static function create(
        TrackId $id,
        TrackName $name,
        TrackPrice $price,
    ): self {
        return new self(
            id:    $id,
            name:  $name,
            price: $price,
        );
    }

    public function __toString(): string
    {
        return substr(strrchr($this::class, '\\'), 1) . ':' . $this->id->value();
    }
}
