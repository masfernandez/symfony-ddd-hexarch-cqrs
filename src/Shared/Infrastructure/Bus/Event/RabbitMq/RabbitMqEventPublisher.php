<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Bus\Event\RabbitMq;

use Masfernandez\Shared\Domain\Bus\Event\DomainEventAbstract;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class RabbitMqEventPublisher implements EventPublisherInterface
{
    public function __construct(protected MessageBusInterface $eventBus)
    {
    }

    public function publish(DomainEventAbstract ...$events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
