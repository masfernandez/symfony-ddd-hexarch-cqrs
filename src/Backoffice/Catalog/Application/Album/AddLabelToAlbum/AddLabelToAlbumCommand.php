<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AddLabelToAlbum;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use Masfernandez\ValueObject\Exception\ValueObjectException;

class AddLabelToAlbumCommand implements SyncCommand
{
    private readonly AlbumId $albumId;
    private readonly LabelId $labelId;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $albumId,
        string $labelId,
    ) {
        $this->albumId = new AlbumId($albumId);
        $this->labelId = new LabelId($labelId);
    }

    public function getAlbumId(): AlbumId
    {
        return $this->albumId;
    }

    public function getLabelId(): LabelId
    {
        return $this->labelId;
    }
}
