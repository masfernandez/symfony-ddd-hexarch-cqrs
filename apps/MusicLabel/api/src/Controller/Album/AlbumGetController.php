<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\AlbumsResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\GetAlbumsQuery;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\GetAlbumQuery;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album\InputRequest\AlbumGetCollectionInputData;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album\InputRequest\AlbumGetInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumGetController extends AbstractController
{
    public function __construct(private readonly BusHandler $bus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_get', methods: ['GET'])]
    public function getSingle(AlbumGetInputData $inputData): JsonResponse
    {
        /* @var AlbumResponse $response */
        $response = $this->bus->dispatch(
            new GetAlbumQuery($inputData->getId())
        );

        $code = ($response->getTotal() === 0) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;
        return new JsonResponse(
            $response->toJson(),
            $code,
            [],
            true
        );
    }

    #[Route(path: '/albums', name: 'album_get_collection', methods: ['GET'])]
    public function getCollection(AlbumGetCollectionInputData $inputData): JsonResponse
    {
        /** @var AlbumsResponse $albumsResponse */
        $albumsResponse = $this->bus->dispatch(
            new GetAlbumsQuery(
                $inputData->getPage(),
                $inputData->getSize(),
                $inputData->getFields(),
                $inputData->getFilters(),
                $inputData->getSort()
            )
        );

        $code = Response::HTTP_OK;
        return new JsonResponse($albumsResponse->toJson(), $code, [], true);
    }
}
