<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use DateTime;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumPublishingDateMother
{
    /**
     * @param \DateTime|\DateTimeImmutable|null $value
     */
    public static function create(?\DateTimeInterface $value = null): AlbumPublishingDate
    {
        return new AlbumPublishingDate(
            $value ?? FakerMother::random()->dateTime->format(AlbumPublishingDate::FORMAT)
        );
    }
}
