<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Update;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\ValueObject\ValueObjectException;

final class UpdateAlbumCommand implements SyncCommand
{
    private readonly AlbumId $id;
    private readonly ?AlbumTitle $title;
    private readonly ?AlbumReleasedAtDate $releasedAtDate;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
        ?string $title,
        ?string $releasedAtDate
    ) {
        $this->id             = new AlbumId($id);
        $this->title          = new AlbumTitle($title);
        $this->releasedAtDate = new AlbumReleasedAtDate($releasedAtDate);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getTitle(): ?AlbumTitle
    {
        return $this->title;
    }

    public function getPublishingDate(): ?AlbumReleasedAtDate
    {
        return $this->releasedAtDate;
    }
}
