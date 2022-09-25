<?php

/**
 * @noinspection PhpUndefinedMethodInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Delete\AlbumDeleter;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumDeleterTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldDeleteAnAlbum(): void
    {
        $command = DeleteAlbumCommandMother::create();
        $album   = AlbumMother::create($command->id());

        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->search($command->id())->andReturns($album);
        $albumRepository->allows()->remove($album);

        (new AlbumDeleter($albumRepository))->execute($command);
    }

    /**
     * @test
     */
    public function itShouldResponseNotFoundException(): void
    {
        $command         = DeleteAlbumCommandMother::create();
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->search($command->id())->andReturns(null);

        // test application service
        $albumDeleter = new AlbumDeleter($albumRepository);
        $this->expectException(AlbumNotFound::class);
        $albumDeleter->execute($command);
    }
}
