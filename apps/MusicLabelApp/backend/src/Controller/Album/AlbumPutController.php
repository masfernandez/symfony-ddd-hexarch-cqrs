<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\PutAlbumCommand;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumPutInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumPutController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_put', methods: ['PUT'])]
    public function updateSingle(AlbumPutInputData $inputData): JsonResponse
    {
        $this->commandBus->dispatch(new PutAlbumCommand(
            $inputData->getId(),
            $inputData->getTitle(),
            $inputData->getPublishingDate()
        ));
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/albums', name: 'album_put_collection', methods: ['PUT'])]
    public function updateCollection(): JsonResponse
    {
        return $this->json(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
