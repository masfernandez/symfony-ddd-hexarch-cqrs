<?php

/**
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Shared;

use Behat\Behat\Context\Context;
use Masfernandez\Tests\Shared\Domain\Persistence\RepositoryCleaner;

final class DataBaseCleanerContext implements Context
{
    public function __construct(private RepositoryCleaner $repositoryCleaner)
    {
    }

    /**
     * @BeforeScenario
     */
    public function cleanData(): void
    {
        $this->repositoryCleaner->truncateDataStored();
    }
}
