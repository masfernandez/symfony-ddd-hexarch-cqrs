<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Controller\Auth;

use Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken\GetTokenQuery;
use Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken\TokenResponse;
use Masfernandez\MusicLabel\Auth\Infrastructure\InputRequest\Token\TokenPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationPostController extends AbstractController
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    #[Route(path: '/authentication', name: 'authentication_post', methods: ['POST'])]
    public function authenticate(TokenPostInputData $inputData): JsonResponse
    {
        /** @var HandledStamp $handledStamp */
        $handledStamp = $this->queryBus->dispatch(new GetTokenQuery(
            $inputData->getEmail(),
            $inputData->getPassword()
        ))->last(HandledStamp::class);

        /** @var TokenResponse $tokenResponse */
        $tokenResponse = $handledStamp->getResult();
        return new JsonResponse(
            null,
            Response::HTTP_CREATED,
            ['Location' => $tokenResponse->getToken()]
        );
    }
}
