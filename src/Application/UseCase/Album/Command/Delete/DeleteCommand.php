<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Delete;

use App\Domain\Bus\CommandInterface;
use App\Domain\Model\Album\AlbumId;

/**
 * Class DeleteCommand
 * @package App\Application\UseCase\Album\Command\Add
 */
final class DeleteCommand implements CommandInterface
{
    /**
     * @var AlbumId
     */
    public $id;

    /**
     * DeleteCommand constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = new AlbumId($id);
    }
}
