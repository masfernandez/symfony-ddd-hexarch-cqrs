<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Application\Album\Patch\AlbumPatcher;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumPatcherTest extends TestCase
{
    /**
     * @test
     * @throws \Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound
     */
    public function itShouldUpdateAnAlbum(): void
    {
        $command = PatchAlbumCommandMother::create();
        $album   = AlbumMother::create(
            id:             $command->getId(),
            title:          $command->getTitle(),
            releaseDate: $command->getPublishingDate()
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($command->getId())->andReturns($album);
        $albumRepository->expects()->patch($album);

        // test application service
        $albumCreator = new AlbumPatcher($albumRepository);
        $albumCreator->execute($command);
    }
}
