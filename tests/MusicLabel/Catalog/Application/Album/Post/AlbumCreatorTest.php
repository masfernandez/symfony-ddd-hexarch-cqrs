<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenRepository;
use Masfernandez\MusicLabel\Catalog\Application\Album\Post\AlbumCreator;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisherInterface;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token\TokenMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEventMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumCreatorTest extends KernelTestCase
{
    /**
     * @test
     */
    public function itShouldCreateAnAlbum(): void
    {
        $command = PostAlbumCommandMother::create();
        $album = AlbumMother::create($command->getId(), $command->getTitle(), $command->getPublishingDate());
        $eventExpected = AlbumCreatedDomainEventMother::create(
            $command->getId(),
            $command->getTitle(),
            $command->getPublishingDate()
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $tokenRepository = Mockery::mock(TokenRepository::class);
        $eventPublisher = Mockery::mock(EventPublisherInterface::class);
        $albumRepository->expects()->post(Mockery::on(
            $this->compareAlbums($album)
        ));
        $tokenRepository->expects()->getByValue($command->getToken())->andReturns(TokenMother::create());
        $eventPublisher->expects()->publish(Mockery::on(
            $this->compareEvents($eventExpected)
        ));

        // test application service
        $albumCreator = new AlbumCreator($albumRepository, $eventPublisher, $tokenRepository);
        $albumCreator->execute($command);
    }

    private function compareAlbums(Album $albumExpected): callable
    {
        return static function ($albumActual) use ($albumExpected) {
            return $albumExpected->compareToAlbum($albumActual);
        };
    }

    private function compareEvents(AlbumCreatedDomainEvent $eventExpected): callable
    {
        return static function ($eventActual) use ($eventExpected) {
            return $eventExpected->aggregateId() === $eventActual->aggregateId() &&
                $eventExpected->getTitle() === $eventActual->getTitle() &&
                $eventExpected->getPublishingDate() === $eventActual->getPublishingDate() &&
                $eventExpected->getId() === $eventActual->getId();
        };
    }
}
