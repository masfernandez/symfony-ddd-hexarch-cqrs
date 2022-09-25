<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class DoctrineDateTimeType extends DoctrineType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $albumReleaseDate = $value->value();

        if ($albumReleaseDate instanceof DateTime) {
            return $albumReleaseDate->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
        }
        return $albumReleaseDate;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $date = (new DateTimeImmutable($value, new DateTimeZone('UTC')))->format(DATE_W3C);
        return parent::convertToPHPValue($date, $platform);
    }
}