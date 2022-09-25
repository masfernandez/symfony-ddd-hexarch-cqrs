<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Create\CreateAlbumCommand;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\BusHandler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumPostCollectionInputData;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest\AlbumPostInputData;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumPostController extends AbstractController
{
    public function __construct(private readonly BusHandler $bus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_post', methods: ['POST'])]
    public function postSingle(AlbumPostInputData $inputData): JsonResponse
    {
        $host = $inputData->getRequest()?->getSchemeAndHttpHost() ??
            throw new RuntimeException('Cannot get Request.');

        return $this->createAlbum(
            [
                'id'           => $inputData->getId(),
                'title'        => $inputData->getTitle(),
                'release_date' => $inputData->getReleaseDate(),
                'price'        => $inputData->getPrice(),
                'token'        => $inputData->getToken(),
            ],
            $host
        );
    }

    /**
     * @param mixed[] $inputData
     */
    private function createAlbum(array $inputData, ?string $host): JsonResponse
    {
        $this->bus->dispatch(
            new CreateAlbumCommand(
                id:             $inputData['id'],
                title:          $inputData['title'],
                releasedAtDate: $inputData['release_date'],
                price:          $inputData['price'],
                token:          $inputData['token']
            )
        );

        $headers = ['Location' => $host . '/albums/' . $inputData['id']];
        $code    = Response::HTTP_CREATED;

        return $this->json(
            null,
            $code,
            $headers
        );
    }

    #[Route(path: '/albums', name: 'album_post_collection', methods: ['POST'])]
    public function postCollection(AlbumPostCollectionInputData $inputData): JsonResponse
    {
        $host = $inputData->getRequest()?->getSchemeAndHttpHost() ??
            throw new RuntimeException('Cannot get Request.');

        return $this->createAlbum(
            [
                'id'           => $inputData->getId(),
                'title'        => $inputData->getTitle(),
                'release_date' => $inputData->getReleaseDate(),
                'price'        => $inputData->getPrice(),
                'token'        => $inputData->getToken(),
            ],
            $host
        );
    }
}
