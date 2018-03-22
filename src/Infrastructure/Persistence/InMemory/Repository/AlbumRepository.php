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
    public function save($album)
    {
        $this->albums[$album->getId()->id()] = $album;
    }

    /**
     * @inheritDoc
     */
    public function findOne($albumId)
    {
        $album = $this->albums[$albumId->id()];

        if (!$album instanceof Album) {
            //@todo exception
        }
        return $this->albums[$albumId->id()];
    }

    /**
     * @inheritDoc
     */
    public function remove($albumId)
    {
        unset($this->albums[$albumId->id()]);
    }
}