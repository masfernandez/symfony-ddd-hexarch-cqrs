<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Symfony;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\Shared\Domain\Model\DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainExceptionListener implements EventSubscriberInterface
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
        $transactional = $exception->getPrevious();
        if (!$transactional instanceof DomainException) {
            return;
        }

        $domainException = $transactional->getPrevious();
        $message = null; // @todo improve final http messages
        $code = match (true) {
            $domainException instanceof AlbumNotFound => Response::HTTP_NOT_FOUND,
            $domainException instanceof AlbumAlreadyExists => Response::HTTP_CONFLICT,
            $domainException instanceof InvalidCredentials => Response::HTTP_UNAUTHORIZED,
            $domainException instanceof UserNotFound => Response::HTTP_NOT_FOUND,
        default => Response::HTTP_INTERNAL_SERVER_ERROR
        };

            $event->setResponse(new JsonResponse(
                $message,
                $code,
            ));
    }
}
