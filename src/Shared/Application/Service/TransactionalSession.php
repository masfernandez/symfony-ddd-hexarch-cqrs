<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Application\Service;

interface TransactionalSession
{
    public function executeTransactionalOperation(callable $operation);
}
