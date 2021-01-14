<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Controller\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Delete\DeleteAlbumCommand;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album\AlbumDeleteInputData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumDeleteController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/albums/{id}', name: 'album_delete', methods: ['DELETE'])]
    public function deleteSingle(AlbumDeleteInputData $inputData): JsonResponse
    {
        $code = Response::HTTP_NO_CONTENT;
        try {
            $this->commandBus->dispatch(new DeleteAlbumCommand($inputData->getId()));
        } catch (HandlerFailedException $ex) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($ex->getPrevious() instanceof AlbumNotFound) {
                $code = Response::HTTP_NOT_FOUND;
            }
        }
        return $this->json(null, $code);
    }

    #[Route(path: '/albums', name: 'album_delete_collection', methods: ['DELETE'])]
    public function deleteCollection(): JsonResponse
    {
        return $this->json(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
