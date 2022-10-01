<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\ValueObject\Exception\ValueObjectException;

final class AlbumAssembler
{
    public static array $jsonMappingToEntity = [
        'id'           => Album::ID,
        'title'        => Album::TITLE,
        'release_date' => Album::RELEASED_AT_DATE,
        'price'        => Album::PRICE,
    ];

    /**
     * @return (AlbumId|AlbumPrice|AlbumReleasedAtDate|AlbumTitle)[]
     *
     * @psalm-return array{id?: AlbumId, title?: AlbumTitle, releasedAtDate?: AlbumReleasedAtDate, price?: AlbumPrice}
     */
    public static function fromEntityToArray(?Album $album): array
    {
        return ($album !== null) ? [
            Album::ID               => $album->getId(),
            Album::TITLE            => $album->getTitle(),
            Album::RELEASED_AT_DATE => $album->getReleasedAtDate(),
            Album::PRICE            => $album->getPrice(),
        ] : [];
    }

    /**
     * @return (float|string)[]
     *
     * @psalm-return array{id?: string, title?: string, releasedAtDate?: string, price?: float}
     */
    public static function fromEntityToArrayPrimitives(?Album $album): array
    {
        return ($album !== null) ? [
            Album::ID               => $album->getId()->value(),
            Album::TITLE            => $album->getTitle()->value(),
            Album::RELEASED_AT_DATE => $album->getReleasedAtDate()->value()->format(DATE_W3C),
            Album::PRICE            => $album->getPrice()->value(),
        ] : [];
    }

    /**
     * @throws ValueObjectException
     */
    public static function fromArrayPrimitivesToEntity(array $albumArray): Album
    {
        return Album::create(
            id:             new AlbumId($albumArray[Album::ID]),
            title:          new AlbumTitle($albumArray[Album::TITLE]),
            releasedAtDate: new AlbumReleasedAtDate($albumArray[Album::RELEASED_AT_DATE]),
            price:          new AlbumPrice($albumArray[Album::PRICE])
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
        if (isset($albumArray[Album::RELEASED_AT_DATE])) {
            $result['release_date'] = $albumArray[Album::RELEASED_AT_DATE]->value()->format(DATE_W3C);
        }
        if (isset($albumArray[Album::PRICE])) {
            $result['price'] = $albumArray[Album::PRICE]->value();
        }

        return $result;
    }

    /**
     * @return (float|string)[]
     *
     * @psalm-return array{id: string, title: string, release_date: string, price: float}
     */
    public static function fromEntityToResponse(Album $album): array
    {
        return [
            'id'           => $album->getId()->value(),
            'title'        => $album->getTitle()->value(),
            'release_date' => $album->getReleasedAtDate()->value()->format(DATE_W3C),
            'price'        => $album->getPrice()->value(),
        ];
    }
}
