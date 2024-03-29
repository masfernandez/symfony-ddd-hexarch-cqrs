<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Infrastructure\Persistence\MySql;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Masfernandez\Tests\MusicLabel\Shared\Domain\Persistence\RepositoryCleaner;

class MySqlCleaner implements RepositoryCleaner
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function truncateDataStored(): void
    {
        $connection = $this->entityManager->getConnection();
        $tables = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);
        $connection->executeStatement($truncateTablesSql);
    }

    /**
     * @return mixed[]
     */
    private function tables(Connection $connection): array
    {
        return $connection->executeQuery('SHOW TABLES')->fetchAllNumeric();
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $sql = array_map(static function ($table): string {
            return ($table[0] === 'doctrine_migration_versions') ? '' : sprintf('TRUNCATE TABLE `%s`;', $table[0]);
        }, $tables);

        return sprintf('SET FOREIGN_KEY_CHECKS = 0; %s SET FOREIGN_KEY_CHECKS = 1;', implode(' ', $sql));
    }
}
