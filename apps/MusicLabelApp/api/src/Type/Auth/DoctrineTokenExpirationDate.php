<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineAbstractType;

final class DoctrineTokenExpirationDate extends DoctrineAbstractType
{
    private const MY_TYPE = 'TokenExpirationDate';

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
                explode("\\", TokenExpirationDate::class),
                0,
                -1
            )
        );
    }
}
