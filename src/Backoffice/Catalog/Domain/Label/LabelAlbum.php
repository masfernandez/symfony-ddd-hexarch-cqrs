<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label;

use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use ReflectionClass;
use Stringable;

class LabelAlbum implements Stringable
{
    private function __construct(
        private readonly Label $label,
        private readonly AlbumId $albumId,
    ) {
    }

    public static function create(
        Label $label,
        AlbumId $albumId,
    ): self {
        return new self(
            label:   $label,
            albumId: $albumId,
        );
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function getAlbumId(): AlbumId
    {
        return $this->albumId;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->label}" . ":{$this->albumId}";
    }
}
