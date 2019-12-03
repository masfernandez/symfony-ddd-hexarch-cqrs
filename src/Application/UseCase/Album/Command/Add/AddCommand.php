<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Add;

use App\Domain\Bus\CommandInterface;

/**
 * Class AddCommand
 * @package App\Application\UseCase\Album\Command\Add
 */
final class AddCommand implements CommandInterface
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var \DateTime
     */
    public $publishing_date;

    /**
     * AddCommand constructor.
     * @param string $title
     * @param \DateTime $publishing_date
     */
    public function __construct(string $title, \DateTime $publishing_date)
    {
        $this->title = $title;
        $this->publishing_date = $publishing_date;
    }
}
