<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\ValueObject\ValueObjectException;

final class DeleteAlbumCommand implements SyncCommand
{
    private readonly AlbumId $id;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
    ) {
        $this->id = new AlbumId($id);
    }

    public function id(): AlbumId
    {
        return $this->id;
    }
}
