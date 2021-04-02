<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Post\PostAlbumCommand;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumPostCollectionInputData;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumPostInputData;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumPostController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_post', methods: ['POST'])]
    public function postSingle(AlbumPostInputData $inputData): JsonResponse
    {
        $host = $inputData->getRequest()?->getSchemeAndHttpHost() ??
            throw new RuntimeException('Cannot get Request.');
        return $this->createAlbum([
            'id' => $inputData->getId(),
            'title' => $inputData->getTitle(),
            'publishing_date' => $inputData->getPublishingDate(),
            'token' => $inputData->getToken()
        ], $host);
    }

    /**
     * @param string[] $inputData
     */
    private function createAlbum(array $inputData, ?string $host): JsonResponse
    {
        $this->commandBus->dispatch(new PostAlbumCommand(
            $inputData['id'],
            $inputData['title'],
            $inputData['publishing_date'],
            $inputData['token']
        ));
        $headers = ['Location' => $host . '/albums/' . $inputData['id']];
        return $this->json(null, Response::HTTP_CREATED, $headers);
    }

    #[Route(path: '/albums', name: 'album_post_collection', methods: ['POST'])]
    public function postCollection(AlbumPostCollectionInputData $inputData): JsonResponse
    {
        $host = $inputData->getRequest()?->getSchemeAndHttpHost() ??
            throw new RuntimeException('Cannot get Request.');
        return $this->createAlbum([
            'id' => $inputData->getId(),
            'title' => $inputData->getTitle(),
            'publishing_date' => $inputData->getPublishingDate(),
            'token' => $inputData->getToken(),
        ], $host);
    }
}
