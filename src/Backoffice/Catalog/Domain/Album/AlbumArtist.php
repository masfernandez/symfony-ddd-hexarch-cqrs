<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\Id\ArtistId;
use ReflectionClass;
use Stringable;

class AlbumArtist implements Stringable
{
    private function __construct(
        private readonly Album $album,
        private readonly ArtistId $artistId,
    ) {
    }

    public static function create(
        Album $album,
        ArtistId $artistId,
    ): self {
        return new self(
            album:    $album,
            artistId: $artistId,
        );
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getArtistId(): ArtistId
    {
        return $this->artistId;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->album}" . ":{$this->artistId}";
    }
}
