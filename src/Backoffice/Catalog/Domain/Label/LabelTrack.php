<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label;

use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;
use ReflectionClass;
use Stringable;

class LabelTrack implements Stringable
{
    private function __construct(
        private readonly Label $label,
        private readonly TrackId $trackId,
    ) {
    }

    public static function create(
        Label $label,
        TrackId $track,
    ): self {
        return new self(
            label:   $label,
            trackId: $track,
        );
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function getTrackId(): TrackId
    {
        return $this->trackId;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->label}" . ":{$this->trackId}";
    }
}
