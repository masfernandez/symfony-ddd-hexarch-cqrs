<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Delete;

use App\Domain\Bus\CommandInterface;

/**
 * Class DeleteCommand
 * @package App\Application\UseCase\Album\Command\Add
 */
final class DeleteCommand implements CommandInterface
{
    /**
     * @var int
     */
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}