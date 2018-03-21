<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Model\Artist\ArtistRepositoryInterface;

/**
 * Class ArtistRepository
 * @package App\Infrastructure\Persistence\InMemory\Repository
 */
class ArtistRepository implements ArtistRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        // TODO: Implement nextIdentity() method.
    }

    /**
     * @var array
     */
    private $artists = [];

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->artists;
    }

    /**
     * @inheritDoc
     */
    public function save($album)
    {
        $this->artists[$album->getId()] = $album;
    }

    /**
     * @inheritDoc
     */
    public function findOne($albumId)
    {
        $album = $this->artists[$albumId];

        if (!$album instanceof Album) {
            //@todo exception
        }
        return $this->artists[$albumId];
    }

    /**
     * @inheritDoc
     */
    public function remove($albumId)
    {
        unset($this->artists[$albumId]);
    }
}