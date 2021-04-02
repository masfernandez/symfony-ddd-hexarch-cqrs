<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Controller\Auth;

use DateTimeImmutable;
use Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken\GetJwtQuery;
use Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken\JwtResponse;
use Masfernandez\MusicLabel\Auth\Infrastructure\InputRequest\Token\JwtPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class JwtAuthenticationPostController extends AbstractController
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    #[Route(path: '/authentication/jwt', name: 'authentication_jwt_post', methods: ['POST'])]
    public function authenticate(JwtPostInputData $inputData): JsonResponse
    {
        /** @var HandledStamp $handledStamp */
        $handledStamp = $this->queryBus->dispatch(new GetJwtQuery(
            $inputData->getEmail(),
            $inputData->getPassword()
        ))->last(HandledStamp::class);

        /** @var JwtResponse $tokenResponse */
        $tokenResponse = $handledStamp->getResult();
        $response = new JsonResponse(
            null,
            Response::HTTP_CREATED,
        );
        $response->headers->set('Location',"header+payload:{$tokenResponse->getHeaderAndPayload()}");
        $response->headers->setCookie(
            new Cookie(
                'signature',
                $tokenResponse->getSignature(),
                0,
                '/',
                null,
                true,
                true,
                false,
                Cookie::SAMESITE_NONE
            )
        );
        return $response;
    }
}
