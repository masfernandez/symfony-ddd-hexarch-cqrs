<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabelApp\Infrastructure\Backend\Kernel;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumTitleMother;
use Masfernandez\Tests\Shared\Domain\Persistence\RepositoryCleaner;
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
        $id = AlbumIdMother::create();
        $album = AlbumMother::create($id);
        $this->albumRepository->post($album);
        $this->entityManager->clear();

        $actualAlbum = $this->albumRepository->getById($id);
        $this->albumRepository->delete($actualAlbum);
        $this->entityManager->clear();

        $expectedNullAlbum = $this->albumRepository->getById($id);
        self::assertNull($expectedNullAlbum);
    }

    /**
     * @test
     */
    public function itShouldGetAnAlbumById(): void
    {
        $id = AlbumIdMother::create();
        $albumExpected = AlbumMother::create($id);
        $this->albumRepository->post($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->getById($id);
        self::assertNotNull($albumActual);
    }

    /**
     * @test
     */
    public function itShouldPatchAnAlbum(): void
    {
        $id = AlbumIdMother::create();
        $album = AlbumMother::create($id);
        $this->albumRepository->post($album);
        $this->entityManager->clear();

        $albumExpected = $this->albumRepository->getById($id);
        $albumExpected->update(AlbumTitleMother::create(), AlbumPublishingDateMother::create());
        $this->albumRepository->patch($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->getById($id);
        self::assertEquals($albumExpected, $albumActual);
    }

    /**
     * @test
     */
    public function itShouldPostAnAlbum(): void
    {
        $album = AlbumMother::create();
        $this->albumRepository->post($album);
    }

    /**
     * @test
     */
    public function itShouldPutAnAlbum(): void
    {
        $id = AlbumIdMother::create();
        $album = AlbumMother::create($id);
        $this->albumRepository->post($album);
        $this->entityManager->clear();

        $albumExpected = $this->albumRepository->getById($id);
        $albumExpected->update(AlbumTitleMother::create(), AlbumPublishingDateMother::create());
        $this->albumRepository->put($albumExpected);
        $this->entityManager->clear();

        $albumActual = $this->albumRepository->getById($id);
        self::assertEquals($albumExpected, $albumActual);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $_SERVER['KERNEL_CLASS'] = Kernel::class;
        parent::setUp();
        self::bootKernel();

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->albumRepository = self::$container->get(AlbumRepository::class) ??
            throw new RuntimeException('Cannot fetch AlbumRepository from DI.');

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->entityManager = self::$container->get(EntityManagerInterface::class) ??
            throw new RuntimeException('Cannot fetch EntityManager from DI.');

        $cleaner = self::$container->get(RepositoryCleaner::class) ??
            throw new RuntimeException('Cannot fetch RepositoryCleaner from DI.');

        $cleaner->truncateDataStored();
    }
}
