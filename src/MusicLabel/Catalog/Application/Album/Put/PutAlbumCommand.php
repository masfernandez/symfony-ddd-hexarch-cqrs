<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Shared\Domain\Bus\Command\SyncCommand;

final class PutAlbumCommand implements SyncCommand
{
    private AlbumId $id;
    private AlbumPublishingDate $publishing_date;
    private AlbumTitle $title;

    public function __construct(string $id, string $title, string $publishing_date)
    {
        $this->id = new AlbumId($id);
        $this->title = new AlbumTitle($title);
        $this->publishing_date = new AlbumPublishingDate($publishing_date);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getPublishingDate(): AlbumPublishingDate
    {
        return $this->publishing_date;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }
}
