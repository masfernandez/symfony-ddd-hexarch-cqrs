<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Domain\Model\Artist\Exception\ArtistException;

/**
 * Class AlbumRepository
 * @package App\Infrastructure\Persistence\InMemory\Repository
 */
class AlbumRepository implements AlbumRepositoryInterface
{
    /**
     * @var array
     */
    private $albums = [];

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        return new AlbumId();
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->albums;
    }

    /**
     * @inheritDoc
     */
    public function save(Album $album)
    {
        $this->albums[$album->getId()->id()] = $album;
    }

    /**
     * @inheritDoc
     */
    public function findOne(AlbumId $albumId) : Album
    {
        $album = $this->albums[$albumId->id()];

        if (!$album instanceof Album) {
            //@todo msg
            throw new ArtistException();
        }

        return $album;
    }

    /**
     * @inheritDoc
     */
    public function remove(AlbumId $albumId)
    {
        if (!isset($this->albums[$albumId->id()])) {
            //@todo msg
            throw new ArtistException();
        }

        unset($this->albums[$albumId->id()]);
    }
}