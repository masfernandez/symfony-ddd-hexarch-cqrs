<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Application\Service;

use Exception;

interface TransactionalSession
{
    /** @throws Exception */
    public function executeTransactionalOperation(callable $operation);
}
