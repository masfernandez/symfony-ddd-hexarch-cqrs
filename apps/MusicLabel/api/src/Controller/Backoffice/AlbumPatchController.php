<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Update\UpdateAlbumCommand;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumPatchInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumPatchController extends AbstractController
{
    public function __construct(private readonly BusHandler $bus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_path', methods: ['PATCH'])]
    public function patchSingle(
        AlbumPatchInputData $inputData,
    ): JsonResponse {
        $this->bus->dispatch(
            new UpdateAlbumCommand(
                $inputData->getId(),
                $inputData->getTitle(),
                $inputData->getReleaseDate()
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/albums', name: 'album_path_collection', methods: ['PATCH'])]
    public function patchCollection(): JsonResponse
    {
        return $this->json(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
