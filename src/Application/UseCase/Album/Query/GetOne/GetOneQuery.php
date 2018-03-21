<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Query\GetOne;

use App\Domain\Bus\QueryInterface;

/**
 * Class GetOneQuery
 * @package App\Application\UseCase\Album\Query\GetOne
 */
final class GetOneQuery implements QueryInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * GetOneQuery constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}