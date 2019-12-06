<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Model\Artist\Artist;
use App\Domain\Model\Artist\ArtistId;
use App\Domain\Model\Artist\ArtistRepositoryInterface;
use App\Domain\Model\Artist\Exception\ArtistException;

/**
 * Class ArtistRepository
 * @package App\Infrastructure\Persistence\InMemory\Repository
 */
class ArtistRepository implements ArtistRepositoryInterface
{
    /**
     * @var array
     */
    private $artists = [];

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        return new ArtistId();
    }

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
    public function save(Artist $artist)
    {
        $this->artists[$artist->getId()->id()] = $artist;
    }

    /**
     * @inheritDoc
     */
    public function findOne(ArtistId $artistId): Artist
    {
        $artist = $this->artists[$artistId->id()];

        if (!$artist instanceof Artist) {
            //@todo msg
            throw new ArtistException();
        }

        return $artist;
    }

    /**
     * @inheritDoc
     */
    public function remove(ArtistId $artistId)
    {
        if (!isset($this->artists[$artistId->id()])) {
            //@todo msg
            throw new ArtistException();
        }

        unset($this->artists[$artistId->id()]);
    }
}