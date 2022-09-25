<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Infrastructure\Behat\Shared;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\MinkExtension\Context\MinkContext;

abstract class AbstractMinkContext extends MinkContext
{
    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusHttpCodeShouldBe($code): void
    {
        $this->assertResponseStatus($code);
    }
}
