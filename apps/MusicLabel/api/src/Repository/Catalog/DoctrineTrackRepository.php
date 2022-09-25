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
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\Exceptions\TrackAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\Track;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\TrackRepository;
use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;

final class DoctrineTrackRepository extends ServiceEntityRepository implements TrackRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Track::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Track $track, bool $flush = true): void
    {
        $this->em->persist($track);

        if ($flush) {
            try {
                $this->em->flush();
            } catch (UniqueConstraintViolationException $ex) {
                // @todo change message here
                throw new TrackAlreadyExists($ex->getMessage(), $ex->getCode(), $ex);
            }
        }
    }

    public function remove(Track $track, bool $flush = true): void
    {
        $this->em->remove($track);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function update(Track $track, bool $flush = true): void
    {
        $this->em->persist($track);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function search(TrackId $id, $lockMode = null, $lockVersion = null): ?Track
    {
        return $this->find($id);
    }

    public function searchOneBy(array $criteria, array $orderBy = null): ?Track
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
}
