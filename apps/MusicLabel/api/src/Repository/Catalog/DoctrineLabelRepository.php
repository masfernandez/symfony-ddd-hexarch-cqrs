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
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Label;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelRepository;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;

final class DoctrineLabelRepository extends ServiceEntityRepository implements LabelRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Label::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Label $label, bool $flush = true): void
    {
        $this->em->persist($label);

        if ($flush) {
            try {
                $this->em->flush();
            } catch (UniqueConstraintViolationException $ex) {
                // @todo change message here
                throw new LabelAlreadyExists($ex->getMessage(), $ex->getCode(), $ex);
            }
        }
    }

    public function remove(Label $label, bool $flush = true): void
    {
        $this->em->remove($label);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function update(Label $label, bool $flush = true): void
    {
        $this->em->persist($label);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function search(LabelId $id, $lockMode = null, $lockVersion = null): ?Label
    {
        return $this->find($id);
    }

    public function searchOneBy(array $criteria, array $orderBy = null): ?Label
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
