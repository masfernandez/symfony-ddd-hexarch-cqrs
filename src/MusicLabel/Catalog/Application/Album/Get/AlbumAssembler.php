<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;

final class AlbumAssembler
{
    /**
     * @return mixed[][]|string[]
     */
    public static function toArray(?Album $album): array
    {
        return ($album !== null) ? $album->toArray() : [];
    }

    public static function fromArray(array $data): Album
    {
        return Album::fromArray($data);
    }
}
