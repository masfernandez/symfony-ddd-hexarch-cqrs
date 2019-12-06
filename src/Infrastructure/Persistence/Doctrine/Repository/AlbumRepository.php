<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Domain\Model\Album\Exception\AlbumException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class AlbumRepository
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class AlbumRepository extends ServiceEntityRepository implements AlbumRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
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
    public function save(Album $album)
    {
        $this->_em->persist($album);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(AlbumId $albumId)
    {
        $album = $this->findOne($albumId);

        if (!$album instanceof Album) {
            //@todo msg
            throw new AlbumException();
        }

        $this->_em->remove($album);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function findOne(AlbumId $albumId): Album
    {
        $album = parent::find($albumId);

        if (!$album instanceof Album) {
            //@todo msg
            throw new AlbumException();
        }

        return $album;
    }

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        return new AlbumId();
    }
}
