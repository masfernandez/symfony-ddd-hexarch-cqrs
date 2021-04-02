<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Auth;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\MinkExtension\Context\MinkContext;

final class TokenMinkContext extends MinkContext
{
    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusCodeShouldBe($code): void
    {
        $this->assertResponseStatus($code);
    }
}
