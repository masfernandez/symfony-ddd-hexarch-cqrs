<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Model\Album\Album;
use App\Infrastructure\Persistence\InMemory\Repository\AlbumRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class AlbumRepositoryTest
 * @package App\Tests\Infrastructure\Persistence\InMemory\Repository
 */
class AlbumRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function testSave()
    {
        $albumRepository = new AlbumRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $albumRepository->save($album);

        if (count($albumRepository->findAll()) != 1) {
            $this->fail();
        }

        $this->assertTrue(count($albumRepository->findAll()) > 0);
    }

    /**
     * @test
     */
    public function testRemove()
    {
        $albumRepository = new AlbumRepository();
        $albumName = 'Album test phpunit';
        $date = new \DateTime();
        $album = new Album(
            $albumRepository->nextIdentity(),
            $albumName,
            $date
        );
        $albumRepository->save($album);

        if (count($albumRepository->findAll()) != 1) {
            $this->fail();
        }

        $albumRepository->remove($album->getId());
        $this->assertTrue(count($albumRepository->findAll()) == 0);
    }

    /**
     * @test
     */
    public function testFindOne()
    {
        //@todo AlbumRepositoryTest:testFindOne
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testFindAll()
    {
        //@todo AlbumRepositoryTest:testFindAll
        $this->assertTrue(true);
    }
}