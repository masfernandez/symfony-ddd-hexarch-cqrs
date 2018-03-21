<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Service;

use Masfernandez\Shared\Application\Service\TransactionalSession;

final class NoTransactionalSession implements TransactionalSession
{
    public function executeTransactionalOperation(callable $operation)
    {
        return $operation();
    }
}
