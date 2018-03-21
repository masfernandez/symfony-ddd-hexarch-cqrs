<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 * @noinspection PhpUndefinedMethodInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Catalog;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behatch\Context\RestContext;
use JsonException;

final class AlbumRestContext extends RestContext
{
    /**
     * @Then the JSON response should be equal to:
     */
    public function theResponseShouldBeEqualTo(PyStringNode $expected): void
    {
        $raw = $expected->getRaw();
        try {
            $expected = ($raw === '') || ($raw === '{}') ? $raw : $json = json_encode(json_decode($raw, true, 512, JSON_THROW_ON_ERROR), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $expected = sprintf('There was a JsonException, message: %s', $e->getMessage());
        }
        $actual = $this->request->getContent();
        $message = "Actual response is '$actual', but expected '$expected'";
        $this->assertEquals($expected, $actual, $message);
    }
}
