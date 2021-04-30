<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenValue;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Shared\Domain\Bus\Command\Command;

final class PostAlbumCommand implements Command
{
    private AlbumId $id;
    private AlbumTitle $title;
    private AlbumPublishingDate $publishing_date;
    private TokenValue $token;

    public function __construct(string $id, string $title, string $publishing_date, string $token)
    {
        $this->id              = AlbumId::fromString($id);
        $this->title           = new AlbumTitle($title);
        $this->publishing_date = new AlbumPublishingDate($publishing_date);
        $this->token           = new TokenValue($token);
    }

    public function getPublishingDate(): AlbumPublishingDate
    {
        return $this->publishing_date;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getToken(): TokenValue
    {
        return $this->token;
    }
}
