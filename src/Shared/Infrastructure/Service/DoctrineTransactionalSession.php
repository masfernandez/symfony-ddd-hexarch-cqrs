<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Service;

use Doctrine\ORM\EntityManagerInterface;
use Masfernandez\Shared\Application\Service\TransactionalSession;

final class DoctrineTransactionalSession implements TransactionalSession
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function executeTransactionalOperation(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}
