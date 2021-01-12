<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Infrastructure\Persistence\Doctrine\Types\DoctrineAbstractType;

final class DoctrineAlbumPublishingDate extends DoctrineAbstractType
{
    private const MY_TYPE = 'AlbumPublishingDate';

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
        return 'Masfernandez\MusicLabel\Catalog\Domain\Model\Album';
    }
}
