<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use DateTime;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumPublishingDateMother
{
    public static function create(?DateTime $value = null): AlbumPublishingDate
    {
        return new AlbumPublishingDate(
            $value ?? FakerMother::random()->dateTime->format(AlbumPublishingDate::$format)
        );
    }
}
