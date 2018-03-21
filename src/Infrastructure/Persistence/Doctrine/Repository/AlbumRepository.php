<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AlbumRepository
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class AlbumRepository extends ServiceEntityRepository implements AlbumRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function save($album)
    {
        if (!$album instanceof Album) {
            //@todo exception
        }

        $this->_em->persist($album);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($albumId)
    {
        $album = $this->findOne($albumId->id());

        if (!$album instanceof Album) {
            //@todo exception
        }

        $this->_em->remove($album);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function findOne($albumId)
    {
        $album = parent::find($albumId);

        if (!$album instanceof Album) {
            //@todo exception
        }

        return $album;
    }

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        // TODO: Implement nextIdentity() method.
    }
}