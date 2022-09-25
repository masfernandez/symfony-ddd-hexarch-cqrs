<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Domain\Persistence;

interface RepositoryCleaner
{
    public function truncateDataStored(): void;
}
