<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Update;

use App\Domain\Bus\CommandInterface;
use App\Domain\Model\Album\AlbumId;

/**
 * Class UpdateCommand
 * @package App\Application\UseCase\Album\Command\Delete
 */
final class UpdateCommand implements CommandInterface
{
    /**
     * @var AlbumId
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var \DateTime
     */
    public $publishing_date;

    /**
     * UpdateCommand constructor.
     * @param string $id
     * @param string $title
     * @param \DateTime $publishing_date
     * @throws \Exception
     */
    public function __construct(string $id, string $title, \DateTime $publishing_date)
    {
        $this->id = new AlbumId($id);
        $this->title = $title;
        $this->publishing_date = $publishing_date;
    }
}
