<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Create;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Create\AlbumCreator;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Event\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\EventPublisher;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumCreatedDomainEventMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumCreatorTest extends KernelTestCase
{
    /**
     * @test
     * @throws AlbumAlreadyExists
     */
    public function itShouldCreateAnAlbum(): void
    {
        $command = PostAlbumCommandMother::create();

        $album = AlbumMother::create(
            id:             $command->getId(),
            title:          $command->getTitle(),
            releasedAtDate: $command->getReleasedAtDate()
        );

        $eventExpected = AlbumCreatedDomainEventMother::create(
            id:             $command->getId(),
            title:          $command->getTitle(),
            releasedAtDate: $command->getReleasedAtDate(),
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $eventPublisher  = Mockery::mock(EventPublisher::class);
        $albumRepository->expects()->add(
            Mockery::on(
                $this->compareAlbums($album)
            )
        );
        $eventPublisher->expects()->publish(
            Mockery::on(
                $this->compareEvents($eventExpected)
            )
        );

        // test application service
        $albumCreator = new AlbumCreator($albumRepository, $eventPublisher);
        $albumCreator->execute($command);
    }

    private function compareAlbums(Album $albumExpected): \Closure
    {
        return static function ($albumActual) use ($albumExpected): bool {
            return $albumExpected->equals($albumActual);
        };
    }

    private function compareEvents(AlbumCreatedDomainEvent $eventExpected): \Closure
    {
        return static function ($eventActual) use ($eventExpected): bool {
            return $eventExpected->aggregateId() === $eventActual->aggregateId() &&
                $eventExpected->getTitle() === $eventActual->getTitle() &&
                $eventExpected->getPublishingDate() === $eventActual->getPublishingDate() &&
                $eventExpected->getId() === $eventActual->getId();
        };
    }
}
