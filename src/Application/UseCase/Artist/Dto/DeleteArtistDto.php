<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

/**
 * Class DeleteArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class DeleteArtistDto
{
    /**
     * @var int
     */
    private $artistId;

    /**
     * DeleteArtistDto constructor.
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