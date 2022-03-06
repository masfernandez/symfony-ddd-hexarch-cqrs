<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Auth;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\TokenRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;

final class DoctrineTokenRepository extends ServiceEntityRepository implements TokenRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function save(Token $token): void
    {
        try {
            $this->_em->persist($token);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException) {
            // @todo
        }
    }

    public function getByValue(TokenValue $token): ?Token
    {
        return $this->_em->createQueryBuilder()
            ->select('t')
            ->from(Token::class, 't')
            ->where('t.value = :value')
            ->setParameter('value', $token->value())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
