<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Domain\User\UserId;
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
        $value = is_string($value) ? $value : $value->value();
        return parent::convertToDatabaseValue($value, $platform);
    }

    protected function getUidClass(): string
    {
        return UserId::class;
    }
}
