<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\AlbumUpdater;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\CacheInMemory;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumUpdaterTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReplaceAnAlbum(): void
    {
        $command = PutAlbumCommandMother::create();
        $album = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($command->getId())->andReturns($album);
        $albumRepository->expects()->put($album);

        $inMemoryRepository = Mockery::mock(CacheInMemory::class);
        $inMemoryRepository->allows()->set(
            $command->getId()->toString(),
            json_encode($album->toArray(), JSON_THROW_ON_ERROR)
        );

        // test application service
        $albumCreator = new AlbumUpdater($albumRepository, $inMemoryRepository);
        $albumCreator->execute($command);
    }

    /**
     * @test
     */
    public function itShouldResponseNotFoundException(): void
    {
        $command = PutAlbumCommandMother::create();

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($command->getId())->andReturns(null);
        $inMemoryRepository = Mockery::mock(CacheInMemory::class);

        // test application service
        $albumCreator = new AlbumUpdater($albumRepository, $inMemoryRepository);
        $this->expectException(AlbumNotFound::class);
        $albumCreator->execute($command);
    }
}
