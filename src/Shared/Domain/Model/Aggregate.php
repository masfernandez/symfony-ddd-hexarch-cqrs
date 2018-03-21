<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\Model;

use Masfernandez\Shared\Domain\Bus\Event\DomainEventAbstract;

abstract class Aggregate
{
    private array $domainEvents = [];

    /**
     * @return DomainEventAbstract[]
     */
    final public function dropEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function collectEvent(DomainEventAbstract $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final protected function countEvents(): int
    {
        return count($this->domainEvents);
    }
}
