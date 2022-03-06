<?php

/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpDocRedundantThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpRedundantCatchClauseInspection
 */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Catalog;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\Persistence\ManagerRegistry;
use JsonException;
use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Application\Album\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumResultSet;
use Masfernandez\MusicLabel\Catalog\Domain\Album\CacheInMemory;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Select;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

final class DoctrineAlbumRepository extends ServiceEntityRepository implements AlbumRepository
{
    public function __construct(ManagerRegistry $registry, private CacheInMemory $cache)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     */
    public function post(Album $album): void
    {
        try {
            $this->_em->persist($album);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $ex) {
            throw new AlbumAlreadyExists('', $ex->getCode(), $ex);
        }
    }

    public function getAll(): AlbumResultSet
    {
        return new AlbumResultSet($this->findAll(), $this->count([]));
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     */
    public function delete(Album $album): void
    {
        $this->_em->remove($album);
        $this->_em->flush();
        $this->cache->del($album->getId()->value());
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     * @throws TransactionRequiredException
     * @throws JsonException
     */
    public function getById(AlbumId $id): ?Album
    {
        $cacheResponse = $this->cache->get($id->value());
        if ($cacheResponse !== false) {
            $albumArray = json_decode($cacheResponse, true, 512, JSON_THROW_ON_ERROR);
            return AlbumAssembler::fromArrayPrimitivesToEntity($albumArray);
        }

        $album = $this->_em->find(Album::class, $id);

        if (!empty($album)) {
            $this->cache->set(
                $album->getId()->value(),
                json_encode(AlbumAssembler::fromEntityToArrayPrimitives($album), JSON_THROW_ON_ERROR)
            );
            return $album;
        }

        return null;
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     * @throws JsonException
     */
    public function put(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();

        $this->cache->set(
            $album->getId()->value(),
            json_encode(AlbumAssembler::fromEntityToArrayPrimitives($album), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     * @throws JsonException
     */
    public function patch(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();

        $this->cache->set(
            $album->getId()->toString(),
            json_encode(AlbumAssembler::fromEntityToArrayPrimitives($album), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws QueryException
     */
    public function getMatching(Select $select, Criteria $criteria): AlbumResultSet
    {
        $albums = $this
            ->createQueryBuilder($criteria->getAlias())
            ->select($select->getFields())
            ->addCriteria($criteria->getCriteria())
            ->getQuery()
            ->execute();

        $total = $this->count([]);

        return new AlbumResultSet($albums, $total);
    }
}
