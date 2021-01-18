<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumsResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\GetAlbumsQuery;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\GetAlbumQuery;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumGetInputData;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumGetCollectionInputData;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumGetController extends AbstractController
{
    public function __construct(private MessageBusInterface $queryBus, private LoggerInterface $appLogger)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_get', methods: ['GET'])]
    public function getSingle(AlbumGetInputData $inputData): JsonResponse
    {
        /* @var HandledStamp $handledStamp */
        $handledStamp = $this->queryBus->dispatch(
            new GetAlbumQuery($inputData->getId())
        )->last(HandledStamp::class);
        /* @var AlbumResponse $response */
        $response = $handledStamp->getResult();
        $code = ($response->getTotal() === 0) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;
        return new JsonResponse($response->toJson(), $code, [], true);
    }

    #[Route(path: '/albums', name: 'album_get_collection', methods: ['GET'])]
    public function getCollection(AlbumGetCollectionInputData $inputData): JsonResponse
    {
        /** @var HandledStamp $handledStamp */
        $handledStamp = $this->queryBus->dispatch(new GetAlbumsQuery(
            $inputData->getPage(),
            $inputData->getSize(),
            $inputData->getFields(),
            $inputData->getFilters(),
            $inputData->getSort()
        ))->last(HandledStamp::class);
        /** @var AlbumsResponse $albumsResponse */
        $albumsResponse = $handledStamp->getResult();
        $code = Response::HTTP_OK;
        return new JsonResponse($albumsResponse->toJson(), $code, [], true);
    }
}
