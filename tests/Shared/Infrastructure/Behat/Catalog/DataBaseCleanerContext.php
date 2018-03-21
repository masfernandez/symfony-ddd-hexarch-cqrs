<?php

/**
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Catalog;

use Behat\Behat\Context\Context;
use Masfernandez\Tests\Shared\Domain\Persistence\RepositoryCleaner;

final class DataBaseCleanerContext implements Context
{
    private RepositoryCleaner $repositoryCleaner;

    public function __construct(RepositoryCleaner $repositoryCleaner)
    {
        $this->repositoryCleaner = $repositoryCleaner;
    }

    /**
     * @BeforeScenario
     */
    public function cleanData(): void
    {
        $this->repositoryCleaner->truncateDataStored();
    }
}
