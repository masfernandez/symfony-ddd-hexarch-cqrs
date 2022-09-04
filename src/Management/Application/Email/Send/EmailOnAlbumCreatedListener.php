<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Management\Application\Email\Send;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\EventHandler;
use Psr\Log\LoggerInterface;

final class EmailOnAlbumCreatedListener implements EventHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    // @todo remove this coupling
    public function execute(AlbumCreatedDomainEvent $event): void
    {
        $this->logger->info('Async AlbumCreatedDomainEvent message received! Album title: ' . $event->getTitle());
    }
}
