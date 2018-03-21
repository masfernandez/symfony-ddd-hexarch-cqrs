<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Criteria;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

interface AlbumRepository
{
    public function getById(AlbumId $id): ?Album;

    public function getAll(): AlbumResultSet;

    public function getMatching(Criteria $criteria): AlbumResultSet;

    /** @throws AlbumAlreadyExistsException */
    public function post(Album $album): void;

    /** @throws AlbumNotFound */
    public function delete(Album $album): void;

    /** @throws AlbumNotFound */
    public function put(Album $album): void;

    /** @throws AlbumNotFound */
    public function patch(Album $album): void;
}
