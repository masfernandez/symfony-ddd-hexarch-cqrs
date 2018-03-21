<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Application\Album\Patch\AlbumPatcher;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
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

        // test application service
        $albumCreator = new AlbumPatcher($albumRepository);
        $albumCreator->execute($command);
    }
}
