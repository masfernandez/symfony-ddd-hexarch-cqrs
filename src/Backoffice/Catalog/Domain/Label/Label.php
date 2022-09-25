<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTrack;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\ValueObject\LabelName;
use Masfernandez\MusicLabel\Shared\Domain\AggregateRoot;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use ReflectionClass;
use Stringable;

class Label extends AggregateRoot implements Stringable
{
    private Collection $albums;
    private Collection $tracks;

    private function __construct(
        private readonly LabelId $id,
        private readonly LabelName $name,
        array $albums,
        array $tracks,
    ) {
        $this->albums = new ArrayCollection();
        foreach ($albums as $album) {
            $this->albums->add($album);
        }
        $this->tracks = new ArrayCollection();
        foreach ($tracks as $track) {
            $this->tracks->add($track);
        }
    }

    public static function create(
        LabelId $id,
        LabelName $name,
        ?array $albums = [],
        ?array $tracks = [],
    ): self {
        return new self(
            id:     $id,
            name:   $name,
            albums: $albums,
            tracks: $tracks,
        );
    }

    public function getId(): LabelId
    {
        return $this->id;
    }

    public function getAlbums(): ArrayCollection
    {
        return $this->albums;
    }

    public function getTracks(): ArrayCollection
    {
        return $this->tracks;
    }

    public function addAlbum(LabelAlbum $album): void
    {
        $this->albums->add($album);
    }

    public function addTrack(AlbumTrack $track): void
    {
        $this->tracks->add($track);
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->id->value()}";
    }
}
