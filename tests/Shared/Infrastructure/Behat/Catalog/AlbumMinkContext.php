<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Catalog;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\MinkExtension\Context\MinkContext;

final class AlbumMinkContext extends MinkContext
{
    /**
     * @Then the response status code should be :code
     *
     * @return void
     */
    public function theResponseStatusCodeShouldBe($code): void
    {
        $this->assertResponseStatus($code);
    }
}
