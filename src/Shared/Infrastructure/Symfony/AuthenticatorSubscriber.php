<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Symfony;

use Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate\AuthenticateJwTokenCommand;
use Masfernandez\MusicLabel\Auth\Application\Token\Authenticate\AuthenticateTokenCommand;
use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenValue;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class AuthenticatorSubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @return array<string, array<int[]|string[]>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 10],
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        $token = $request->headers->get('Authorization') ?? false;
        if ($token === false) {
            return;
        }

        $signature = $request->cookies->get('signature') ?? false;
        $token = str_replace('Bearer ', '', $token);
        if ($this->isHeaderAndPayPattern($token) && $signature !== false) {
            $command = new AuthenticateJwTokenCommand($token . '.' . $signature);
        } else {
            $command = new AuthenticateTokenCommand($token);
        }

        try {
            $this->commandBus->dispatch($command);
        } catch (HandlerFailedException) {
            $event->setResponse(new JsonResponse(
            //@todo set json api message here
                ['error' => 'Invalid credentials'],
                Response::HTTP_FORBIDDEN
            ));
        }
    }

    private function isHeaderAndPayPattern(?string $token): bool
    {
        return 1 === preg_match(JwTokenValue::JWT_HEAD_AND_PAY_PATTERN, $token);
    }
}
