<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Auth;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getByEmail(UserEmail $email): ?User
    {
        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :searchEmail')
            ->setParameter('searchEmail', $email->value())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function getByEmailAndPassword(UserEmail $email, UserPassword $password): ?User
    {
        $user = $this->_em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :searchEmail')
            ->setParameter('searchEmail', $email->value())
            ->andWhere('u.password = :searchPassword')
            ->setParameter('searchPassword', $password->value())
            ->getQuery()
            ->execute();
        return $user ?? null;
    }

    /** @noinspection PhpRedundantCatchClauseInspection */
    public function post(User $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $ex) {
            // @todo change message here
            throw new UserAlreadyExists('User already exist in database', $ex->getCode(), $ex);
        }
    }
}
