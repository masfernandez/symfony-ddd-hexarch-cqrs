<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Management\Application\Email\Send;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEvent;
use Masfernandez\Shared\Domain\Bus\Event\EventHandlerInterface;
use Psr\Log\LoggerInterface;

final class EmailOnAlbumCreatedListener implements EventHandlerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(AlbumCreatedDomainEvent $event)
    {
        $this->logger->info('Async AlbumCreatedDomainEvent message received! Album title: ' . $event->getTitle());
    }
}
