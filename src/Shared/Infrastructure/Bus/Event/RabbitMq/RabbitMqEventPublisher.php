<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Bus\Event\RabbitMq;

use Masfernandez\Shared\Domain\Bus\Event\DomainEvent;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisher;
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
