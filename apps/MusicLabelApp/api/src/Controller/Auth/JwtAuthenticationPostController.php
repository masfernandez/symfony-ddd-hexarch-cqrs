<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth;

use Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken\GetJwtQuery;
use Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken\JwtResponse;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth\InputRequest\JwtPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JwtAuthenticationPostController extends AbstractController
{
    public function __construct(private BusHandler $bus)
    {
    }

    #[Route(path: '/authentication/jwt', name: 'authentication_jwt_post', methods: ['POST'])]
    public function authenticate(JwtPostInputData $inputData): JsonResponse
    {
        /** @var JwtResponse $tokenResponse */
        $tokenResponse = $this->bus->dispatch(
            new GetJwtQuery(
                $inputData->getEmail(),
                $inputData->getPassword()
            )
        );

        $response = new JsonResponse(
            null,
            Response::HTTP_CREATED,
        );
        $response->headers->set('Location', "header+payload:{$tokenResponse->getHeaderAndPayload()}");
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
