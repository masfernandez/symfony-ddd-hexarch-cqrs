<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Replace;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Replace\AlbumReplacer;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumUpdaterTest extends TestCase
{
    /**
     * @test
     * @throws AlbumNotFound
     */
    public function itShouldReplaceAnAlbum(): void
    {
        $command = PutAlbumCommandMother::create();
        $album   = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->search($command->getId())->andReturns($album);
        $albumRepository->expects()->update($album);

        // test application service
        $albumCreator = new AlbumReplacer($albumRepository);
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
        $albumRepository->allows()->search($command->getId())->andReturns(null);

        // test application service
        $albumCreator = new AlbumReplacer($albumRepository);
        $this->expectException(AlbumNotFound::class);
        $albumCreator->execute($command);
    }
}
