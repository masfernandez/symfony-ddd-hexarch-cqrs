<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Service;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Label;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelAlbum;

final class AssignAlbumToLabelService
{
    /**
     * @throws AlbumAlreadyExists
     */
    public function assign(Label $label, Album $album): void
    {
        $labelAlbum = LabelAlbum::create(
            label:   $label,
            albumId: $album->getId(),
        );

        if ($label->getAlbums()->contains($labelAlbum)) {
            throw new AlbumAlreadyExists();
        }

        $label->addAlbum($labelAlbum);

        $album->addLabelId(labelId: $label->getId());
    }
}
