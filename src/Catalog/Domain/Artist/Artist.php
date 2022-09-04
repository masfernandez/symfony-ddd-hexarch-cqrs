<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Artist;

use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumCollection;
use Masfernandez\MusicLabel\Shared\Domain\Artist\ArtistId;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class Artist implements Stringable
{
    public final const ID = 'id';
    public final const NAME = 'name';
    public final const SPECIALISATION = 'specialisation';

    private readonly ArtistAddingDate $adding_date;

    public function __construct(
        private readonly ArtistId $id,
        private ArtistName $name,
        private ArtistSpecialisation $specialisation,
        private readonly AlbumCollection $albums
    ) {
        $this->adding_date = new ArtistAddingDate([]);
    }

    public static function fromPrimitives($primitiveData): Artist
    {
        $albums = [];
        foreach ($primitiveData['album'] as $album) {
            $albums[] = AlbumAssembler::fromEntityToArray($album);
        }
        return new Artist(
            new ArtistId($primitiveData['id']),
            new ArtistName($primitiveData['name']),
            new ArtistSpecialisation($primitiveData['specialisation']),
            new AlbumCollection($albums)
        );
    }

    public function update(ArtistName $name, ArtistSpecialisation $specialisation): void
    {
        $this->name           = $name;
        $this->specialisation = $specialisation;
    }

    public function addAlbum(Album $album): void
    {
        //$album->addArtist($this); // synchronously updating inverse side
        $this->albums->add($album);
    }

    public function deleteAlbum(Album $album): void
    {
        if ($this->albums->contains($album)) {
            $this->albums->delete($album);
        }
    }

    /**
     * @return array<string, string>
     */
    public function toPrimitives(): array
    {
        return [
            'id'             => $this->id->value(),
            'name'           => $this->name->value(),
            'specialisation' => $this->specialisation->value(),
            'adding_date'    => $this->adding_date->value()->format(ArtistAddingDate::FORMAT)
        ];
    }

    public function __toString(): string
    {
        return $this::class . ':' . $this->id->value();
    }
}
