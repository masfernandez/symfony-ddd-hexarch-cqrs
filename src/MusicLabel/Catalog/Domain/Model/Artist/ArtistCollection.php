<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Artist;

use Doctrine\Common\Collections\ArrayCollection;

final class ArtistCollection extends ArrayCollection
{
    /**
     * @return array<int, mixed[]>
     */
    public function toPrimitives(): array
    {
        $primitives = [];
        /** @var Artist $artist */
        foreach ($this->getValues() as $artist) {
            $primitives[] = $artist->toPrimitives();
        }
        return $primitives;
    }
}
