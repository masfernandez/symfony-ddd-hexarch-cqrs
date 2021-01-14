<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Domain\Model\Artist\ArtistId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DoctrineArtistId extends AbstractUidType
{
    private const MY_TYPE = 'ArtistId';

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
        return ArtistId::class;
    }
}
