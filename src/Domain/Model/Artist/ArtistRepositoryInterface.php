<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Artist;

use App\Domain\Model\Artist\Exception\ArtistException;

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
    public function save(Artist $artist);

    /**
     * @param ArtistId $artistId
     * @return Artist
     * @throws ArtistException
     */
    public function findOne(ArtistId $artistId): Artist;

    /**
     * @param ArtistId $artistId
     * @throws ArtistException
     */
    public function remove(ArtistId $artistId);

    /**
     * @return ArtistId
     */
    public function nextIdentity();
}
