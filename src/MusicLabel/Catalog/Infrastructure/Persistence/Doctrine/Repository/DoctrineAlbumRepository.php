<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumResultSet;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\CacheInMemory;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

final class DoctrineAlbumRepository extends ServiceEntityRepository implements AlbumRepository
{
    public function __construct(ManagerRegistry $registry, private CacheInMemory $cache)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @throws AlbumAlreadyExists
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @noinspection PhpRedundantCatchClauseInspection
     */
    public function post(Album $album): void
    {
        try {
            $this->_em->persist($album);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $ex) {
            // @todo change message here
            throw new AlbumAlreadyExists('', (int)$ex->getCode(), $ex);
        }
    }

    public function getAll(): AlbumResultSet
    {
        return new AlbumResultSet($this->findAll(), $this->count($this->findAll()), []);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(Album $album): void
    {
        $this->_em->remove($album);
        $this->_em->flush();
        $this->cache->del($album->getId()->value());
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \JsonException
     */
    public function getById(AlbumId $id): ?Album
    {
        $cacheResponse = $this->cache->get($id->value());
        if ($cacheResponse !== false) {
            $albumArray = json_decode($cacheResponse, true, 512, JSON_THROW_ON_ERROR);
            return Album::createFromArray($albumArray);
        }

        $album = $this->_em->find(Album::class, $id);

        if (!empty($album)) {
            $this->cache->set(
                $album->getId()->value(),
                json_encode($album->toArray(), JSON_THROW_ON_ERROR)
            );
            return $album;
        }

        return null;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \JsonException
     */
    public function put(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();

        $this->cache->set(
            $album->getId()->value(),
            json_encode($album->toArray(), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \JsonException
     */
    public function patch(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();

        $this->cache->set(
            $album->getId()->toString(),
            json_encode($album->toArray(), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getMatching(Criteria $criteria): AlbumResultSet
    {
        $query = $this
            ->createQueryBuilder($criteria->getAlias())
            ->addCriteria($criteria->getCriteria())
            ->getQuery();

        $paginator = new Paginator($query);
        $albums    = $paginator->getQuery()->execute();
        $total     = $paginator->count();
        return new AlbumResultSet($albums, $total, $criteria->getFieldsToFilter());
    }
}
