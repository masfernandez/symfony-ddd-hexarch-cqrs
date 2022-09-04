<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineAbstractType;

final class DoctrineTokenValue extends DoctrineAbstractType
{
    private const MY_TYPE = 'TokenValue';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    protected function getNamespace(): string
    {
        return implode(
            "\\",
            array_slice(
                explode("\\", TokenValue::class),
                0,
                -1
            )
        );
    }
}
