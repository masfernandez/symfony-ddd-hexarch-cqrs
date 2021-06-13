<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Application\Album\Post\AlbumCreator;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisher;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEventMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumCreatorTest extends KernelTestCase
{
    /**
     * @test
     * @throws \Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExists
     */
    public function itShouldCreateAnAlbum(): void
    {
        $command       = PostAlbumCommandMother::create();
        $album         = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());
        $eventExpected = AlbumCreatedDomainEventMother::create(
            $command->getId(),
            $command->getTitle(),
            $command->getPublishingDate()
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $eventPublisher  = Mockery::mock(EventPublisher::class);
        $albumRepository->expects()->post(
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

    private function compareAlbums(Album $albumExpected): callable
    {
        return static function ($albumActual) use ($albumExpected): bool {
            return $albumExpected->equals($albumActual);
        };
    }

    private function compareEvents(AlbumCreatedDomainEvent $eventExpected): callable
    {
        return static function ($eventActual) use ($eventExpected): bool {
            return $eventExpected->aggregateId() === $eventActual->aggregateId() &&
                $eventExpected->getTitle() === $eventActual->getTitle() &&
                $eventExpected->getPublishingDate() === $eventActual->getPublishingDate() &&
                $eventExpected->getId() === $eventActual->getId();
        };
    }
}
