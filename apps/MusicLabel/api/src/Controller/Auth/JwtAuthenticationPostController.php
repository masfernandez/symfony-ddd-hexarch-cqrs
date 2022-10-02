<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth;

use Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Create\CreateJsonWebTokenCommand;
use Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Create\JsonWebTokenResponse;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth\InputRequest\JwtPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JwtAuthenticationPostController extends AbstractController
{
    public function __construct(private readonly BusHandler $bus)
    {
    }

    #[Route(path: '/authentication/jwt', name: 'authentication_jwt_post', methods: ['POST'])]
    public function authenticate(JwtPostInputData $inputData): JsonResponse
    {
        /** @var JsonWebTokenResponse $tokenResponse */
        $tokenResponse = $this->bus->dispatch(
            new CreateJsonWebTokenCommand(
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
