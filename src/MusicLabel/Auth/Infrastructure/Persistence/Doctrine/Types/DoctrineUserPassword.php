<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Masfernandez\MusicLabel\Shared\Infrastructure\Persistence\Doctrine\Types\DoctrineAbstractType;

class DoctrineUserPassword extends DoctrineAbstractType
{
    private const MY_TYPE = 'UserPassword';

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
        return 'Masfernandez\MusicLabel\Auth\Domain\Model\User';
    }
}