<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineAbstractType;

final class DoctrineAlbumReleaseDate extends DoctrineAbstractType
{
    private const MY_TYPE = 'AlbumReleaseDate';

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }

    protected function getNamespace(): string
    {
        return implode(
            "\\",
            array_slice(
                explode("\\", AlbumReleaseDate::class),
                0,
                -1
            )
        );
    }
}
