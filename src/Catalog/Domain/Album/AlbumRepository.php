<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

interface AlbumRepository
{
    public function getById(AlbumId $id): ?Album;

    public function getAll(): AlbumResultSet;

    public function getMatching(Select $select, Criteria $criteria): AlbumResultSet;

    /** @throws AlbumAlreadyExists */
    public function post(Album $album): void;

    /** @throws AlbumNotFound */
    public function delete(Album $album): void;

    /** @throws AlbumNotFound */
    public function put(Album $album): void;

    /** @throws AlbumNotFound */
    public function patch(Album $album): void;
}
