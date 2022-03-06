<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth;

use Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken\GetTokenQuery;
use Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken\TokenResponse;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth\InputRequest\TokenPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationPostController extends AbstractController
{
    public function __construct(private BusHandler $bus)
    {
    }

    #[Route(path: '/authentication', name: 'authentication_post', methods: ['POST'])]
    public function authenticate(TokenPostInputData $inputData): JsonResponse
    {
        /** @var TokenResponse $tokenResponse */
        $tokenResponse = $this->bus->dispatch(
            new GetTokenQuery(
                $inputData->getEmail(),
                $inputData->getPassword()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_CREATED,
            ['Location' => $tokenResponse->getToken()]
        );
    }
}
