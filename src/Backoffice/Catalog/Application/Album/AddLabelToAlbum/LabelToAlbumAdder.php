<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AddLabelToAlbum;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelNotFound;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Service\AssignLabelToAlbumService;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class LabelToAlbumAdder implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly LabelRepository $labelRepository,
        private readonly AssignLabelToAlbumService $assignLabelToAlbum,
    ) {
    }

    /**
     * @throws AlbumNotFound
     * @throws LabelNotFound
     */
    public function execute(Request|AddLabelToAlbumCommand $request): ?Response
    {
        $label = $this->labelRepository->search($request->getLabelId()) ??
            throw new LabelNotFound();

        $album = $this->albumRepository->search($request->getAlbumId()) ??
            throw new AlbumNotFound();

        $this->assignLabelToAlbum->assign(
            album: $album,
            label: $label,
        );

        return null;
    }
}
