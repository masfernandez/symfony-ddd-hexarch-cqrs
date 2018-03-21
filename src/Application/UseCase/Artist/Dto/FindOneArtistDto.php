<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

/**
 * Class FindOneArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class FindOneArtistDto
{
    /**
     * @var int
     */
    private $artistId;

    /**
     * FindOneArtistDto constructor.
     * @param int $artistId
     */
    public function __construct(int $artistId)
    {
        $this->artistId = $artistId;
    }

    /**
     * @return int
     */
    public function getArtistId(): int
    {
        return $this->artistId;
    }
}