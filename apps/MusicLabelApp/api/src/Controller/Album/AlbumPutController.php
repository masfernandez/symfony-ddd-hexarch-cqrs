<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\PutAlbumCommand;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album\InputRequest\AlbumPutInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumPutController extends AbstractController
{
    public function __construct(private BusHandler $bus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_put', methods: ['PUT'])]
    public function updateSingle(AlbumPutInputData $inputData): JsonResponse
    {
        $this->bus->dispatch(
            new PutAlbumCommand(
                $inputData->getId(),
                $inputData->getTitle(),
                $inputData->getPublishingDate()
            )
        );
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/albums', name: 'album_put_collection', methods: ['PUT'])]
    public function updateCollection(): JsonResponse
    {
        return $this->json(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
