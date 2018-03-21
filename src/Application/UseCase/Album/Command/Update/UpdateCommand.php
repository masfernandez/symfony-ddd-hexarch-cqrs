<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Update;

use App\Domain\Bus\CommandInterface;

/**
 * Class UpdateCommand
 * @package App\Application\UseCase\Album\Command\Delete
 */
final class UpdateCommand implements CommandInterface
{
    /**
     * @var int
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
     * @param int $id
     * @param string $title
     * @param \DateTime $publishing_date
     */
    public function __construct(int $id, string $title, \DateTime $publishing_date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->publishing_date = $publishing_date;
    }
}