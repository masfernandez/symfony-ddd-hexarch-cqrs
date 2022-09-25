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
use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\TokenRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;

final class DoctrineTokenRepository extends ServiceEntityRepository implements TokenRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
        $this->em = $this->getEntityManager();
    }

    public function save(Token $token): void
    {
        try {
            $this->em->persist($token);
            $this->em->flush();
        } catch (UniqueConstraintViolationException) {
            // @todo
        }
    }

    public function getByValue(TokenValue $token): ?Token
    {
        return $this->em->createQueryBuilder()
            ->select('t')
            ->from(Token::class, 't')
            ->where('t.value = :value')
            ->setParameter('value', $token->value())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
