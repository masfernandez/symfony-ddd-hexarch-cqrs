<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Bus\Event\InMemory;

use Masfernandez\Shared\Domain\Bus\Event\DomainEvent;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisher;
use Symfony\Component\Messenger\MessageBusInterface;

final class InMemoryEventPublisher implements EventPublisher
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
