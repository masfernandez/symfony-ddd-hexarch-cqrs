<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\ValueObject\ValueObjectException;

final class CreateAlbumCommand implements Command
{
    private readonly AlbumId $id;
    private readonly AlbumTitle $title;
    private readonly AlbumReleasedAtDate $releasedAtDate;
    private readonly AlbumPrice $price;
    private readonly TokenValue $token;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
        string $title,
        string $releasedAtDate,
        float $price,
        string $token,
    ) {
        $this->id             = new AlbumId($id);
        $this->title          = new AlbumTitle($title);
        $this->releasedAtDate = new AlbumReleasedAtDate($releasedAtDate);
        $this->price          = new AlbumPrice($price);
        $this->token          = new TokenValue($token);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }

    public function getReleasedAtDate(): AlbumReleasedAtDate
    {
        return $this->releasedAtDate;
    }

    public function getPrice(): AlbumPrice
    {
        return $this->price;
    }

    public function getToken(): TokenValue
    {
        return $this->token;
    }
}
