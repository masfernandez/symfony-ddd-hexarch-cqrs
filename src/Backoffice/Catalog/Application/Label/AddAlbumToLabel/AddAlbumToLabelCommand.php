<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\AddAlbumToLabel;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use Masfernandez\ValueObject\Exception\ValueObjectException;

class AddAlbumToLabelCommand implements SyncCommand
{
    private readonly LabelId $labelId;
    private readonly AlbumId $albumId;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $labelId,
        string $albumId,
    ) {
        $this->albumId = new AlbumId($albumId);
        $this->labelId = new LabelId($labelId);
    }

    public function getLabelId(): LabelId
    {
        return $this->labelId;
    }

    public function getAlbumId(): AlbumId
    {
        return $this->albumId;
    }
}
