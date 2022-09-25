<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Infrastructure\Api\Kernel;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTitleMother;
use Masfernandez\Tests\MusicLabel\Shared\Domain\Persistence\RepositoryCleaner;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineAlbumRepositoryTest extends KernelTestCase
{
    private AlbumRepository $albumRepository;
    private EntityManager $entityManager;

    /**
     * @test
     */
    public function itShouldDeleteAnAlbum(): void
    {
        $id    = AlbumIdMother::create();
        $album = AlbumMother::create($id);
        $this->albumRepository->add($album);
//        $this->entityManager->clear();

        $actualAlbum = $this->albumRepository->search($id);
        $this->albumRepository->remove($actualAlbum);
//        $this->entityManager->clear();

        $expectedNullAlbum = $this->albumRepository->search($id);
        self::assertNull($expectedNullAlbum);
    }

    /**
     * @test
     */
    public function itShouldGetAnAlbumById(): void
    {
        $id            = AlbumIdMother::create();
        $albumExpected = AlbumMother::create($id);
        $this->albumRepository->add($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->search($id);
        self::assertNotNull($albumActual);
    }

    /**
     * @test
     */
    public function itShouldPatchAnAlbum(): void
    {
        $id    = AlbumIdMother::create();
        $album = AlbumMother::create(id: $id);
        $album->dropEvents();
        $this->albumRepository->add($album);
        $this->entityManager->clear();

        $albumExpected = $this->albumRepository->search($id);
        $albumExpected->update(
            AlbumTitleMother::create(),
            AlbumReleaseDateMother::create()
        );
        $this->albumRepository->update($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->search($id);
        $albumActual->dropEvents();
        self::assertObjectEquals($albumActual, $albumExpected);
    }

    /**
     * @test
     */
    public function itShouldPostAnAlbum(): void
    {
        $album = AlbumMother::create();
        $this->albumRepository->add($album);
    }

    /**
     * @test
     */
    public function itShouldPutAnAlbum(): void
    {
        $id    = AlbumIdMother::create();
        $album = AlbumMother::create($id);
        $this->albumRepository->add($album);
        $this->entityManager->clear();

        $albumExpected = $this->albumRepository->search($id);
        $albumExpected->update(AlbumTitleMother::create(), AlbumReleaseDateMother::create());
        $this->albumRepository->update($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->search($id);
        self::assertObjectEquals($albumActual, $albumExpected);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $_SERVER['KERNEL_CLASS'] = Kernel::class;
        parent::setUp();
        self::bootKernel();

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->albumRepository = static::getContainer()->get(AlbumRepository::class) ??
            throw new RuntimeException('Cannot fetch AlbumRepository from DI.');

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class) ??
            throw new RuntimeException('Cannot fetch EntityManager from DI.');

        $cleaner = static::getContainer()->get(RepositoryCleaner::class) ??
            throw new RuntimeException('Cannot fetch RepositoryCleaner from DI.');

        $cleaner->truncateDataStored();
    }
}
