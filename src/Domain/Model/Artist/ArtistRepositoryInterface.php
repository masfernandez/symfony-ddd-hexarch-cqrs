<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Artist;

/**
 * Interface ArtistRepositoryInterface
 * @package App\Domain\Model\Artist
 */
interface ArtistRepositoryInterface
{
    /**
     * @return Artist[]
     */
    public function findAll();

    /**
     * @param Artist $artist
     */
    public function save($artist);

    /**
     * @param ArtistId $artistId
     * @return Artist
     */
    public function findOne($artistId);

    /**
     * @param ArtistId $artistId
     */
    public function remove($artistId);

    /**
     * @return ArtistId
     */
    public function nextIdentity();
}