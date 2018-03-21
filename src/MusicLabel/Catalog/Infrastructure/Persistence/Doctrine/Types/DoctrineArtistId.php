<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineArtistId extends DoctrineAbstractType
{
    private const MY_TYPE = 'ArtistId';

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    protected function getNamespace(): string
    {
        return 'Masfernandez\MusicLabel\Shared';
    }
}
