<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;

class ConnectionFactoryDecorator
{
//    public function __construct(
//        private readonly iterable $customTypes,
//    ) {
//        parent::__construct($this->configureTypes());
//    }
//
//    private function configureTypes(): array
//    {
//        foreach ($this->customTypes as $customType) {
//        }
//
//        return [];
//    }

    public function __construct(
        private readonly ?ConnectionFactory $decorated,
        iterable $customTypes
    ) {
        foreach ($customTypes as $customType) {
            echo $customType;
        }
    }
}