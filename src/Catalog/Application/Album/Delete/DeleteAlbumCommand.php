<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;

final class DeleteAlbumCommand implements SyncCommand
{
    private readonly AlbumId $id;

    public function __construct(string $id)
    {
        $this->id = new AlbumId($id);
    }

    public function id(): AlbumId
    {
        return $this->id;
    }
}
