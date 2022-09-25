<?php

/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpDocRedundantThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpRedundantCatchClauseInspection
 */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Auth;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
    }

    public function add(User $user, bool $flush = true): void
    {
        $this->em->persist($user);

        if ($flush) {
            try {
                $this->em->flush();
            } catch (UniqueConstraintViolationException $ex) {
                // @todo change message here
                throw new UserAlreadyExists($ex->getMessage(), $ex->getCode(), $ex);
            }
        }
    }

    public function remove(User $user, bool $flush = true): void
    {
        $this->em->remove($user);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function update(User $user, bool $flush = true): void
    {
        $this->em->persist($user);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function search(UserId $id, $lockMode = null, $lockVersion = null): ?User
    {
        return $this->find($id);
    }

    public function searchOneBy(array $criteria, array $orderBy = null): ?User
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

    // @todo refactor: use searchOneBy method

    /** @noinspection PhpUnhandledExceptionInspection */
    public function getByEmail(UserEmail $email): ?User
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->value())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    // @todo remove: not used
    public function getByEmailAndPassword(UserEmail $email, UserPassword $password): ?User
    {
        $user = $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->value())
            ->andWhere('u.password = :password')
            ->setParameter('password', $password->value())
            ->getQuery()
            ->execute();
        return $user ?? null;
    }

    public function searchByToken(TokenValue $token): ?User
    {
        $user = $this->em->createQueryBuilder()
            ->select('u,t')
            ->from(User::class, 'u')
            ->join('u.tokens','t','WITH','t.value = :token')
            ->setParameter('token', $token->value())
            ->getQuery()
            ->getOneOrNullResult();
        return $user ?? null;
    }
}
