<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Application\Album\Patch\AlbumPatcher;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\InMemoryRepository;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumPatcherTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldUpdateAnAlbum(): void
    {
        $command = PatchAlbumCommandMother::create();
        $album = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($command->getId())->andReturns($album);
        $albumRepository->expects()->patch($album);

        $inMemoryRepository = Mockery::mock(InMemoryRepository::class);
        $inMemoryRepository->allows()->set(
            $command->getId()->toString(),
            json_encode($album->toArray(), JSON_THROW_ON_ERROR)
        );

        // test application service
        $albumCreator = new AlbumPatcher($albumRepository, $inMemoryRepository);
        $albumCreator->execute($command);
    }
}
