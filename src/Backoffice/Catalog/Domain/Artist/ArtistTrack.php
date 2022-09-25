<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist;

use Masfernandez\MusicLabel\Shared\Domain\Id\Artist;
use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;

class ArtistTrack
{
    private function __construct(
        private readonly Artist $artist,
        private readonly TrackId $trackId,
    ) {
    }

    public static function create(
        Artist $artist,
        TrackId $trackId,
    ): self {
        return new self(
            artist:  $artist,
            trackId: $trackId,
        );
    }
}
