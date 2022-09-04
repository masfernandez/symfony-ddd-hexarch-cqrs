<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineAbstractType;
use Masfernandez\MusicLabel\Shared\Domain\User\TokenId;

final class DoctrineTokenId extends DoctrineAbstractType
{
    private const MY_TYPE = 'TokenId';

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }

    protected function getNamespace(): string
    {
        return implode("\\", array_slice(explode("\\", TokenId::class), 0, -1));
    }
}
