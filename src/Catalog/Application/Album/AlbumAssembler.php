<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album;

use DateTimeInterface;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

final class AlbumAssembler
{
    public static array $jsonMappingToEntity = [
        'id'           => Album::ID,
        'title'        => Album::TITLE,
        'release_date' => Album::RELEASE_DATE,
    ];

    /**
     * @return array<string, AlbumReleaseDate>|array<string, AlbumTitle>|array<string, AlbumId>
     */
    public static function fromEntityToArray(?Album $album): array
    {
        return ($album !== null) ? [
            Album::ID           => $album->getId(),
            Album::TITLE        => $album->getTitle(),
            Album::RELEASE_DATE => $album->getReleaseDate(),
        ] : [];
    }

    /**
     * @return array<string, DateTimeInterface>|array<string, string>
     */
    public static function fromEntityToArrayPrimitives(?Album $album): array
    {
        return ($album !== null) ? [
            Album::ID           => $album->getId()->value(),
            Album::TITLE        => $album->getTitle()->value(),
            Album::RELEASE_DATE => $album->getReleaseDate()->value(),
        ] : [];
    }

    public static function fromArrayPrimitivesToEntity(array $albumArray): Album
    {
        return Album::create(
            id:          new AlbumId($albumArray[Album::ID]),
            title:       new AlbumTitle($albumArray[Album::TITLE]),
            releaseDate: new AlbumReleaseDate($albumArray[Album::RELEASE_DATE]),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function fromArrayToResponse(array $albumArray): array
    {
        $result = [];

        if (isset($albumArray[Album::ID])) {
            $result['id'] = $albumArray[Album::ID]->value();
        }
        if (isset($albumArray[Album::TITLE])) {
            $result['title'] = $albumArray[Album::TITLE]->value();
        }
        if (isset($albumArray[Album::RELEASE_DATE])) {
            $result['release_date'] = $albumArray[Album::RELEASE_DATE]->value();
        }

        return $result;
    }

    /**
     * @return array<string, string>
     */
    public static function fromEntityToResponse(Album $album): array
    {
        return [
            'id'           => $album->getId()->value(),
            'title'        => $album->getTitle()->value(),
            'release_date' => $album->getReleaseDate()->value(),
        ];
    }
}
