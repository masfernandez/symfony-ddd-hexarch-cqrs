<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Album;

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
    public function save($album);

    /**
     * @param AlbumId $albumId
     * @return Album
     */
    public function findOne($albumId);

    /**
     * @param AlbumId $albumId
     */
    public function remove($albumId);

    /**
     * @return AlbumId
     */
    public function nextIdentity();
}