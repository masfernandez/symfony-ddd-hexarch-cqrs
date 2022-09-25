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
use Behatch\Context\JsonContext;

abstract class AbstractJsonContext extends JsonContext
{
}
