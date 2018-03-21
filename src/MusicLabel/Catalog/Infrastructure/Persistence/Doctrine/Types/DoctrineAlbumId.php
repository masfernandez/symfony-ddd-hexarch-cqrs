<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DoctrineAlbumId extends AbstractUidType
{
    private const MY_TYPE = 'AlbumId';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->value(), $platform);
    }

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    protected function getUidClass(): string
    {
        return AlbumId::class;
    }
}
