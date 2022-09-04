<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event;

use Masfernandez\MusicLabel\Shared\Domain\DomainEvent;

interface EventPublisher
{
    public function publish(DomainEvent ...$events): void;
}
