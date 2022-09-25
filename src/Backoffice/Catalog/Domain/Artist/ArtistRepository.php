<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Artist\Exceptions\ArtistAlreadyExists;

interface ArtistRepository
{
    /** @throws ArtistAlreadyExists */
    public function post(Artist $artist): void;
}
