<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist;

use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Shared\Domain\Id\Artist;

class ArtistAlbum
{
    private function __construct(
        private readonly Artist $artist,
        private readonly AlbumId $albumId,
    ) {
    }

    public static function create(
        Artist $artist,
        AlbumId $albumId,
    ): self {
        return new self(
            artist:  $artist,
            albumId: $albumId,
        );
    }
}
