<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineAbstractType;

final class DoctrineUserEmail extends DoctrineAbstractType
{
    private const MY_TYPE = 'UserEmail';

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
        return implode("\\", array_slice(explode("\\", UserEmail::class), 0, -1));
    }
}
