<?php

/** @noinspection SqlResolve */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Persistence\Sqlite;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Masfernandez\Tests\Shared\Domain\Persistence\RepositoryCleaner;

class SqliteCleaner implements RepositoryCleaner
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function truncateDataStored(): void
    {
        $connection = $this->entityManager->getConnection();
        $tables = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);
        $connection->executeStatement($truncateTablesSql);
    }

    private function tables(Connection $connection): array
    {
        return $connection->executeQuery("SELECT name FROM sqlite_master WHERE type='table'")->fetchAllNumeric();
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $sql = array_map(static function ($table): string {
            return ($table[0] === 'doctrine_migration_versions') ? '' : sprintf('DELETE FROM `%s`;', $table[0]);
        }, $tables);

        return sprintf('PRAGMA foreign_keys = OFF; %s PRAGMA foreign_keys = ON;', implode(' ', $sql));
    }
}
