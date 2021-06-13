<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\AlbumUpdater;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumUpdaterTest extends TestCase
{
    /**
     * @test
     * @throws \Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound
     */
    public function itShouldReplaceAnAlbum(): void
    {
        $command = PutAlbumCommandMother::create();
        $album   = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($command->getId())->andReturns($album);
        $albumRepository->expects()->put($album);

        // test application service
        $albumCreator = new AlbumUpdater($albumRepository);
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

        // test application service
        $albumCreator = new AlbumUpdater($albumRepository);
        $this->expectException(AlbumNotFound::class);
        $albumCreator->execute($command);
    }
}
