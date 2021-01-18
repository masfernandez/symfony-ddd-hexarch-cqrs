<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use ArrayIterator;
use IteratorAggregate;

final class AlbumCollection implements IteratorAggregate
{
    private int $size;

    public function __construct(private array $albums)
    {
        $this->size = count($this->albums);
    }

    /**
     * @return mixed[]
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    public function add(Album $album): void
    {
        $this->albums[spl_object_hash($album)] = $album;
    }

    public function delete(Album $album): void
    {
        if ($this->contains($album)) {
            unset($this->albums[spl_object_hash($album)]);
        }
    }

    public function contains(Album $album): bool
    {
        return isset($this->albums[spl_object_hash($album)]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->albums);
    }

    public function size(): int
    {
        return $this->size;
    }
}
