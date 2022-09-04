<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Bus;

use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyMessengerHandler implements BusHandler
{
    public function __construct(
        private readonly MessageBusInterface $defaultBus,
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    public function dispatch(Request $request): ?Response
    {
        $envelope = match (true) {
            $request instanceof Command => $this->commandBus->dispatch($request),
            $request instanceof Request => $this->queryBus->dispatch($request),
            default => $this->defaultBus->dispatch($request),
        };

        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
