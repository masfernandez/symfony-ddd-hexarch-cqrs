<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Subscriber;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Domain\DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception       = $event->getThrowable();
        $domainException = $exception->getPrevious();
        if (!$domainException instanceof DomainException) {
            return;
        }
        $message = null; // @todo improve final http messages

        /** @noinspection PhpDuplicateMatchArmBodyInspection */
        $code = match (true) {
            $domainException instanceof AlbumNotFound => Response::HTTP_NOT_FOUND,
            $domainException instanceof AlbumAlreadyExists => Response::HTTP_CONFLICT,
            $domainException instanceof WrongPassword => Response::HTTP_UNAUTHORIZED,
            $domainException instanceof UserNotFound => Response::HTTP_UNAUTHORIZED,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };

        $event->setResponse(
            new JsonResponse(
                $message,
                $code,
            )
        );
    }
}
