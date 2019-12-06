<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Model\Album\Album;
use App\Domain\Model\Artist\Artist;
use App\Domain\Model\Artist\Exception\ArtistException;
use App\Infrastructure\Persistence\InMemory\Repository\AlbumRepository;
use App\Infrastructure\Persistence\InMemory\Repository\ArtistRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class ArtistRepositoryTest
 * @package App\Tests\Infrastructure\Persistence\InMemory\Repository
 */
class ArtistRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function testSave()
    {
        $albumRepository = new AlbumRepository();
        $artistRepository = new ArtistRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $artistName = 'Artist test phpunit';
        $artistSpecilisation = 'guitar phpunit';
        $artist = new Artist(
            $artistRepository->nextIdentity(),
            $artistName,
            $artistSpecilisation,
            $date,
            $album
        );
        $artistRepository->save($artist);

        if (count($artistRepository->findAll()) != 1) {
            $this->fail();
        }

        $this->assertTrue(count($artistRepository->findAll()) > 0);
    }

    /**
     * @test
     */
    public function testRemove()
    {
        $albumRepository = new AlbumRepository();
        $artistRepository = new ArtistRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $artistName = 'Artist test phpunit';
        $artistSpecilisation = 'guitar phpunit';
        $artist = new Artist(
            $artistRepository->nextIdentity(),
            $artistName,
            $artistSpecilisation,
            $date,
            $album
        );
        $artistRepository->save($artist);

        if (count($artistRepository->findAll()) != 1) {
            $this->fail();
        }

        try {
            $artistRepository->remove($artist->getId());
            $this->assertTrue(count($artistRepository->findAll()) == 0);
        } catch (ArtistException $ex) {
            $this->fail($ex->getMessage());
        }
    }

    /**
     * @test
     */
    public function testFindOne()
    {
        $albumRepository = new AlbumRepository();
        $artistRepository = new ArtistRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $artistName = 'Artist test phpunit';
        $artistSpecilisation = 'guitar phpunit';
        $artist = new Artist(
            $artistRepository->nextIdentity(),
            $artistName,
            $artistSpecilisation,
            $date,
            $album
        );
        $artistRepository->save($artist);

        if (count($artistRepository->findAll()) != 1) {
            $this->fail();
        }

        try {
            $artistFound = $artistRepository->findOne($artist->getId());
            $this->assertTrue($artistFound->getId()->id() === $artist->getId()->id());
        } catch (ArtistException $ex) {
            $this->fail($ex->getMessage());
        }
    }

    /**
     * @test
     */
    public function testFindAll()
    {
        $albumRepository = new AlbumRepository();
        $artistRepository = new ArtistRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $artistName = 'Artist test phpunit';
        $artistSpecilisation = 'guitar phpunit';
        $artist = new Artist(
            $artistRepository->nextIdentity(),
            $artistName,
            $artistSpecilisation,
            $date,
            $album
        );
        $artistRepository->save($artist);

        if (count($artistRepository->findAll()) != 1) {
            $this->fail();
        }

        $this->assertTrue(count($artistRepository->findAll()) == 1);
    }
}