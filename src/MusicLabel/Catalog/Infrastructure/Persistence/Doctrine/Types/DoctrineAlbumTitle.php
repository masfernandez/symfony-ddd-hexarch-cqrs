<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineAlbumTitle extends DoctrineAbstractType
{
    private const MY_TYPE = 'AlbumTitle';

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    protected function getNamespace(): string
    {
        return 'Masfernandez\MusicLabel\Catalog\Domain\Model\Album';
    }
}
