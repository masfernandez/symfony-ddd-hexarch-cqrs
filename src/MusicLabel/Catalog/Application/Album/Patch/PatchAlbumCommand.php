<?php

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Shared\Domain\Bus\Command\SyncCommandInterface;

final class PatchAlbumCommand implements SyncCommandInterface
{
    private AlbumId $id;
    private ?AlbumTitle $title;
    private ?AlbumPublishingDate $publishing_date;

    public function __construct(string $id, ?string $title, ?string $publishing_date)
    {
        $this->id = new AlbumId($id);
        $this->title = new AlbumTitle($title);
        $this->publishing_date = new AlbumPublishingDate($publishing_date);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getTitle(): ?AlbumTitle
    {
        return $this->title;
    }

    public function getPublishingDate(): ?AlbumPublishingDate
    {
        return $this->publishing_date;
    }
}
