<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection\AlbumsResponse;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection\SearchAlbumsQuery;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single\AlbumResponse;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single\SearchAlbumQuery;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumGetCollectionInputData;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumGetInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumGetController extends AbstractController
{
    public function __construct(
        private readonly BusHandler $bus,
    ) {
    }

    #[Route(path: '/albums/{id}', name: 'album_get', methods: ['GET'])]
    public function getSingle(AlbumGetInputData $inputData): JsonResponse
    {
        /* @var AlbumResponse $albumResponse */
        $albumResponse = $this->bus->dispatch(
            new SearchAlbumQuery($inputData->getId())
        );

        $code = ($albumResponse->getTotal() === 0) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return new JsonResponse(
            $albumResponse->toJson(),
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
            new SearchAlbumsQuery(
                $inputData->getPage(),
                $inputData->getSize(),
                $inputData->getFields(),
                $inputData->getFilters(),
                $inputData->getSort()
            )
        );

        $code = Response::HTTP_OK;

        return new JsonResponse(
            $albumsResponse->toJson(),
            $code,
            [],
            true
        );
    }
}
