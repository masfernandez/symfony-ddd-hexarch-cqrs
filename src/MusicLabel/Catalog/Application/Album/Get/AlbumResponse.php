<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get;

final class AlbumResponse
{
    /**
     * @param mixed[] $album
     */
    public function __construct(private array $album)
    {
    }

    public function getTotal(): int
    {
        return count($this->album);
    }

    public function toJson(): string
    {
        return json_encode(
            [
                'data' => $this->album,
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
