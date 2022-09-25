<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\Uid\Uuid;

abstract class DoctrineUuidType extends DoctrineType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 16;
        $column['fixed']  = true;
        return $platform->getBinaryTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        if ($value === null) {
            return null;
        }
        $className = $this->getFQCN();
        return new $className(Uuid::fromBinary($value)->toRfc4122());
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }
        $uuid = (is_object($value)) ? $value->value() : $value;
        return Uuid::fromString($uuid)->toBinary();
    }
}