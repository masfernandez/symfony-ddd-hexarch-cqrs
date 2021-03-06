<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Domain\Model\User\UserId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DoctrineUserId extends AbstractUidType
{
    private const MY_TYPE = 'UserId';

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->value(), $platform);
    }

    protected function getUidClass(): string
    {
        return UserId::class;
    }
}
