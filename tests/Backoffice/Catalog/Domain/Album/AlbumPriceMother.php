<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumPriceMother
{
    public static function create(
        ?float $price = null,
    ): AlbumPrice {
        return new AlbumPrice(
            $price ?? FakerMother::random()->randomFloat(2, 1, 200),
        );
    }
}
