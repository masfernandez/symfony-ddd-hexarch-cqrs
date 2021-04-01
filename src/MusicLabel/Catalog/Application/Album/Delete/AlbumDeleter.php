<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumDeleter implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(DeleteAlbumCommand|Request $request): void
    {
        $album = $this->repository->getById($request->id()) ??
            throw new AlbumNotFound();
        $this->repository->delete($album);
    }
}
