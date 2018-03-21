<?php

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Domain\Persistence;

interface RepositoryCleaner
{
    public function truncateDataStored(): void;
}
