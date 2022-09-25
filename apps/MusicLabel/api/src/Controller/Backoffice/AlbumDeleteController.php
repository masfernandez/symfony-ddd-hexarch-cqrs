<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Delete\DeleteAlbumCommand;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumDeleteInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumDeleteController extends AbstractController
{
    public function __construct(private readonly BusHandler $bus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_delete', methods: ['DELETE'])]
    public function deleteSingle(AlbumDeleteInputData $inputData): JsonResponse
    {
        $this->bus->dispatch(
            new DeleteAlbumCommand(
                id: $inputData->getId(),
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/albums', name: 'album_delete_collection', methods: ['DELETE'])]
    public function deleteCollection(): JsonResponse
    {
        return $this->json(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
