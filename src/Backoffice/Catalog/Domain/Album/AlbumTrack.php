<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;
use ReflectionClass;
use Stringable;

class AlbumTrack implements Stringable
{
    private function __construct(
        private readonly Album $album,
        private readonly TrackId $trackId,
    ) {
    }

    public static function create(
        Album $album,
        TrackId $trackId,
    ): self {
        return new self(
            album:   $album,
            trackId: $trackId,
        );
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getTrackId(): TrackId
    {
        return $this->trackId;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->album}" . ":{$this->trackId}";
    }
}
