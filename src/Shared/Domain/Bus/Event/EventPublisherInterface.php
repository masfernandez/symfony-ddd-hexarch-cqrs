<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\Bus\Event;

interface EventPublisherInterface
{
    public function publish(DomainEventAbstract ...$events): void;
}
