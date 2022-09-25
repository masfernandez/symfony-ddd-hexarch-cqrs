<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Service;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Label;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelAlbum;

final class AssignLabelToAlbumService
{
    public function assign(Album $album, Label $label): void
    {
        $album->addLabelId(
            labelId: $label->getId(),
        );

        $label->addAlbum(
            LabelAlbum::create(
                label:   $label,
                albumId: $album->getId(),
            )
        );
    }
}
