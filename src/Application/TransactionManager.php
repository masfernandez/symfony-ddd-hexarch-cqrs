<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application;

/**
 * Interface TransactionManager
 * @package App\Application
 */
interface TransactionManager
{
    /**
     * Begin transaction
     */
    public function begin(): void;

    /**
     * Commit transaction
     */
    public function commit(): void;

    /**
     * Rollback transaction
     */
    public function rollback(): void;
}
