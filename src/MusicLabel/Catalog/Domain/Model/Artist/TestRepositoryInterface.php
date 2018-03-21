<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Artist;

interface TestRepositoryInterface
{
    public function getString(string $test): string;

    public function getUser(string $user): string;
}
