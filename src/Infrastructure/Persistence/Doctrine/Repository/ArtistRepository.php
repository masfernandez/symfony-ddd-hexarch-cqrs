<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Artist\Artist;
use App\Domain\Model\Artist\ArtistId;
use App\Domain\Model\Artist\ArtistRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ArtistRepository
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class ArtistRepository extends ServiceEntityRepository implements ArtistRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artist::class);
    }

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
    public function save($artist)
    {
        $this->_em->persist($artist);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function findOne($artistId)
    {
        $artist = parent::find($artistId);
        if (!$artist instanceof Artist) {
            //@todo exception
        }

        return $artist;
    }

    /**
     * @inheritDoc
     */
    public function remove($artistId)
    {
        $this->_em->remove($artistId);
        $this->_em->flush();
    }

}