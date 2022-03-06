<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Exception;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;

final class PostAlbumCommand implements Command
{
    private AlbumId $id;
    private AlbumTitle $title;
    private AlbumReleaseDate $releaseDate;
    private TokenValue $token;

    /**
     * @throws Exception
     */
    public function __construct(string $id, string $title, string $releaseDate, string $token)
    {
        $this->id             = AlbumId::fromString($id);
        $this->title          = new AlbumTitle($title);
        $this->releaseDate = new AlbumReleaseDate($releaseDate);
        $this->token          = new TokenValue($token);
    }

    public function getPublishingDate(): AlbumReleaseDate
    {
        return $this->releaseDate;
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
