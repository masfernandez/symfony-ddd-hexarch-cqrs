<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Update;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Update\AlbumUpdater;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumPatcherTest extends TestCase
{
    /**
     * @test
     * @throws AlbumNotFound
     */
    public function itShouldUpdateAnAlbum(): void
    {
        $command = PatchAlbumCommandMother::create();
        $album   = AlbumMother::create(
            id:             $command->getId(),
            title:          $command->getTitle(),
            releasedAtDate: $command->getPublishingDate()
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->search($command->getId())->andReturns($album);
        $albumRepository->expects()->update($album);

        // test application service
        $albumCreator = new AlbumUpdater($albumRepository);
        $albumCreator->execute($command);
    }
}
