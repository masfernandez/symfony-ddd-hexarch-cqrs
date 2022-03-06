<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\RabbitMq;

use Masfernandez\MusicLabel\Shared\Domain\DomainEvent;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\EventPublisher;
use Symfony\Component\Messenger\MessageBusInterface;

final class RabbitMqEventPublisher implements EventPublisher
{
    public function __construct(protected MessageBusInterface $eventBus)
    {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
