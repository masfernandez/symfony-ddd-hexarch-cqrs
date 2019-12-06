<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine;

use App\Application\TransactionManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineORMTransactionManager
 * @package App\Infrastructure\Persistence\Doctrine
 */
final class DoctrineORMTransactionManager implements TransactionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DoctrineORMTransactionManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function begin(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}
