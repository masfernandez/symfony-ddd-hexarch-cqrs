<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Catalog;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Masfernandez\MusicLabel\Catalog\Domain\Artist\Artist;
use Masfernandez\MusicLabel\Catalog\Domain\Artist\ArtistRepository;

final class DoctrineArtistRepository extends ServiceEntityRepository implements ArtistRepository
{
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function post(Artist $artist): void
    {
        $sql = "
            INSERT INTO artists
            (
                id,
                name,
                specialisation,
                adding_date
            )
            VALUES
            (
                :id,
                :name,
                :specialisation,
                :adding_date
            )
        ";

        // Examples with registry (should be declared as property class)
        $this->registry->getManager('default');
        $this->registry->getConnection('default');


        // Examples with em
        // $em = $this->getEntityManager();

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);
        $fields    = $artist->toPrimitives();

        $statement->bindValue('id', $fields[Artist::ID], ParameterType::BINARY);
        $statement->bindValue('name', $fields[Artist::NAME], ParameterType::STRING);
        $statement->bindValue('specialisation', $fields[Artist::SPECIALISATION], ParameterType::STRING);
        $statement->bindValue('adding_date', $fields['adding_date'], ParameterType::STRING);
        $statement->executeStatement();
    }
}
