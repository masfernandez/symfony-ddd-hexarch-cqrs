<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExistsException;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumResultSet;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

final class DoctrineAlbumRepository extends ServiceEntityRepository implements AlbumRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /** @noinspection PhpRedundantCatchClauseInspection */
    public function post(Album $album): void
    {
        try {
            $this->_em->persist($album);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $ex) {
            // @todo change message here
            throw new AlbumAlreadyExistsException('', (int)$ex->getCode(), $ex);
        }
    }

    public function getAll(): AlbumResultSet
    {
        return new AlbumResultSet($this->findAll(), $this->count($this->findAll()), []);
    }

    public function delete(Album $album): void
    {
        $this->_em->remove($album);
        $this->_em->flush();
    }

    public function getById(AlbumId $id): ?Album
    {
        $album = $this->_em->find(Album::class, $id);
        return $album ?? null;
    }

    public function put(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();
    }

    public function patch(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();
    }

    public function getMatching(Criteria $criteria): AlbumResultSet
    {
        $query = $this
            ->createQueryBuilder($criteria->getAlias())
            ->addCriteria($criteria->getCriteria())
            ->getQuery();
        $paginator = new Paginator($query);
        $albums = $paginator->getQuery()->execute();
        $total = $paginator->count();
        return new AlbumResultSet($albums, $total, $criteria->getFieldsToFilter());
    }
}
