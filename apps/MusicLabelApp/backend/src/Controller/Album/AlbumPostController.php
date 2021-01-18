<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Controller\Album;

use Exception;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Catalog\Application\Album\Post\PostAlbumCommand;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExistsException;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumPostCollectionInputData;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumPostInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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
            throw new \RuntimeException('Cannot get Request.');
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
        $headers = ['Location' => $host . '/albums/' . $inputData['id']];
        $data = null;
        $code = Response::HTTP_CREATED;
        try {
            $this->commandBus->dispatch(new PostAlbumCommand(
                $inputData['id'],
                $inputData['title'],
                $inputData['publishing_date'],
                $inputData['token']
            ));
        } catch (Exception | HandlerFailedException $ex) {
            $headers = [];
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            // @todo change data message here
            $data = ['errors' => [$ex->getMessage()]];
            if ($ex->getPrevious() instanceof AlbumAlreadyExistsException) {
                // @todo change data message here
                $data = null;
                $code = Response::HTTP_CONFLICT;
            }
            if ($ex->getPrevious() instanceof InvalidCredentials) {
                // @todo change data message here
                $data = null;
                $code = Response::HTTP_UNAUTHORIZED;
            }
        }
        return $this->json($data, $code, $headers);
    }

    #[Route(path: '/albums', name: 'album_post_collection', methods: ['POST'])]
    public function postCollection(AlbumPostCollectionInputData $inputData): JsonResponse
    {
        $host = $inputData->getRequest()?->getSchemeAndHttpHost() ??
            throw new \RuntimeException('Cannot get Request.');
        return $this->createAlbum([
            'id' => $inputData->getId(),
            'title' => $inputData->getTitle(),
            'publishing_date' => $inputData->getPublishingDate(),
            'token' => $inputData->getToken(),
        ], $host);
    }
}
