<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist;

use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist\ValueObject\ArtistName;
use Masfernandez\MusicLabel\Shared\Domain\Id\ArtistId;
use Masfernandez\ValueObject\ValueObjectException;
use Stringable;

class Artist implements Stringable
{
    public final const ID   = 'id';
    public final const NAME = 'name';

    private function __construct(
        private readonly ArtistId $id,
        private ArtistName $name,
        /** @var ArtistTrack[] $tracks */
        private array|Collection $tracks,
        /** @var ArtistAlbum[] $albums */
        private array|Collection $albums,
    ) {
    }

    public static function create(
        ArtistId $id,
        ArtistName $name,
        ?array $tracks = [],
        ?array $albums = [],
    ): self {
        return new self(
            id:     $id,
            name:   $name,
            tracks: $tracks,
            albums: $albums,
        );
    }

    /**
     * @throws ValueObjectException
     */
    public static function fromPrimitives($primitiveData): Artist
    {
        return new Artist(
            id:     new ArtistId($primitiveData['id']),
            name:   new ArtistName($primitiveData['name']),
            tracks: $primitiveData['tracks'],
            albums: $primitiveData['albums']
        );
    }

    public function update(ArtistName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array<string, string>
     */
    public function toPrimitives(): array
    {
        return [
            'id'   => $this->id->value(),
            'name' => $this->name->value(),
        ];
    }

    public function __toString(): string
    {
        return $this::class . ':' . $this->id->value();
    }
}
