<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Catalog;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist\Artist;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist\ArtistRepository;

final class DoctrineArtistRepository extends ServiceEntityRepository implements ArtistRepository
{
    private EntityManager $em;

    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
        $this->em = $this->getEntityManager();
    }

    public function post(Artist $artist): void
    {
        $sql = "
            INSERT INTO artists
            (
                id,
                name,
                specialisation,
            )
            VALUES
            (
                :id,
                :name,
                :specialisation,
            )
        ";

        // Examples with registry (should be declared as property class)
        $this->registry->getManager('default');
        $this->registry->getConnection('default');

        // Examples with em
        // $em = $this->getEntityManager();
        // or just $this->em (see constructor);

        $statement = $this->em->getConnection()->prepare($sql);
        $fields    = $artist->toPrimitives();

        $statement->bindValue('id', $fields[Artist::ID], ParameterType::BINARY);
        $statement->bindValue('name', $fields[Artist::NAME], ParameterType::STRING);
        $statement->executeStatement();
    }
}
