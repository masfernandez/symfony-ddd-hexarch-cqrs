<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\Bus\Event;

interface EventPublisher
{
    public function publish(DomainEvent ...$events): void;
}
