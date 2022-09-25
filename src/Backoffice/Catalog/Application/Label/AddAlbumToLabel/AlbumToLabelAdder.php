<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\AddAlbumToLabel;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelNotFound;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Service\AssignAlbumToLabelService;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class AlbumToLabelAdder implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly LabelRepository $labelRepository,
        private readonly AssignAlbumToLabelService $assignAlbumToLabelService,
    ) {
    }

    /**
     * @throws AlbumNotFound
     * @throws LabelNotFound
     * @throws AlbumAlreadyExists
     */
    public function execute(Request|AddAlbumToLabelCommand $request): ?Response
    {
        $label = $this->labelRepository->search($request->getLabelId()) ??
            throw new LabelNotFound();
        $album = $this->albumRepository->search($request->getAlbumId()) ??
            throw new AlbumNotFound();

        $this->assignAlbumToLabelService->assign(
            label: $label,
            album: $album,
        );

        return null;
    }
}
