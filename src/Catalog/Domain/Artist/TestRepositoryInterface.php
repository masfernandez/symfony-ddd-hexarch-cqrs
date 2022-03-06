<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Artist;

interface TestRepositoryInterface
{
    public function getString(string $test): string;

    public function getUser(string $user): string;
}
