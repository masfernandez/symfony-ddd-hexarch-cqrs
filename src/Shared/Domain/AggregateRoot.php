<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Shared\Domain;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    /**
     * @return DomainEvent[]
     */
    final public function dropEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function collectEvent(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final protected function countEvents(): int
    {
        return count($this->domainEvents);
    }
}
