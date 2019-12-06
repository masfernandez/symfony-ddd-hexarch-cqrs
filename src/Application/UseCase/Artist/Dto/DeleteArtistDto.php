<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;
use App\Domain\Model\Artist\ArtistId;

/**
 * Class DeleteArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class DeleteArtistDto
{
    /**
     * @var ArtistId
     */
    private $artistId;

    /**
     * DeleteArtistDto constructor.
     * @param string $artistId
     */
    public function __construct(string $artistId)
    {
        $this->artistId = new ArtistId($artistId);
    }

    /**
     * @return ArtistId
     */
    public function getArtistId(): ArtistId
    {
        return $this->artistId;
    }
}