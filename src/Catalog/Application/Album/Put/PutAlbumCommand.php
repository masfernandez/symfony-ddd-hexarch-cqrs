<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use Exception;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;

final class PutAlbumCommand implements SyncCommand
{
    private readonly AlbumId $id;
    private readonly AlbumTitle $title;
    private readonly AlbumReleaseDate $releaseDate;

    /**
     * @throws Exception
     */
    public function __construct(string $id, string $title, string $releaseDate)
    {
        $this->id             = new AlbumId($id);
        $this->title          = new AlbumTitle($title);
        $this->releaseDate = new AlbumReleaseDate($releaseDate);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getPublishingDate(): AlbumReleaseDate
    {
        return $this->releaseDate;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }
}
