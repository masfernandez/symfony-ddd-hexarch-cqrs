<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Album;

use App\Domain\Model\Album\Exception\AlbumException;

/**
 * Interface AlbumRepositoryInterface
 * @package App\Domain\Model\Album
 */
interface AlbumRepositoryInterface
{
    /**
     * @return Album[]
     */
    public function findAll();

    /**
     * @param Album $album
     */
    public function save(Album $album);

    /**
     * @param AlbumId $albumId
     * @return Album
     * @throws AlbumException
     */
    public function findOne(AlbumId $albumId) : Album;

    /**
     * @param AlbumId $albumId
     * @throws AlbumException
     */
    public function remove(AlbumId $albumId);

    /**
     * @return AlbumId
     */
    public function nextIdentity();
}