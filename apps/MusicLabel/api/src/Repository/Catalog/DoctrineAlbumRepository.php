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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\Persistence\ManagerRegistry;
use JsonException;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumResultSet;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Shared\Application\Criteria;
use Masfernandez\MusicLabel\Shared\Application\Select;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;

final class DoctrineAlbumRepository extends ServiceEntityRepository implements AlbumRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Album $album, bool $flush = true): void
    {
        $this->em->persist($album);
        try {
            if ($flush) {
                $this->em->flush();
            }
        } catch (UniqueConstraintViolationException $ex) {
            throw new AlbumAlreadyExists('', $ex->getCode(), $ex);
        }
    }

    public function remove(Album $album, bool $flush = true): void
    {
        $this->em->remove($album);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     * @throws JsonException
     */
    public function update(Album $album, bool $flush = true): void
    {
        $this->em->persist($album);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws MissingMappingDriverImplementation
     * @throws TransactionRequiredException
     * @throws JsonException
     */
    public function search(AlbumId $id): ?Album
    {
        return $this->em->find(Album::class, $id);
    }

    public function searchOneBy(array $criteria, array $orderBy = null): ?Album
    {
        return $this->findOneBy($criteria, $orderBy);
    }

    /** @return object[] */
    public function searchAll(): array
    {
        return $this->findAll();
    }

    /** @return object[] */
    public function searchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function countBy(array $criteria): int
    {
        return $this->count($criteria);
    }

    public function getAll(): AlbumResultSet
    {
        return new AlbumResultSet($this->findAll(), $this->count([]));
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
