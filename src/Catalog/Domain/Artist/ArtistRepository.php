<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Artist;

interface ArtistRepository
{
    /** @throws ArtistAlreadyExists */
    public function post(Artist $artist): void;
}
