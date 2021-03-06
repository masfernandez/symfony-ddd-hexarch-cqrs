<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class BadRequestExceptionListener implements EventSubscriberInterface
{
    /**
     * @return array<string, array<int|string>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof BadRequest) {
            $event->setResponse(
                new JsonResponse(
                    ['errors' => $exception->getErrors()],
                    Response::HTTP_BAD_REQUEST,
                )
            );
        }
    }
}
