<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Criteria;
use Masfernandez\MusicLabel\Shared\Application\Select;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;

interface AlbumRepository
{
    /** @throws AlbumAlreadyExists */
    public function add(Album $album, bool $flush = true): void;

    public function remove(Album $album, bool $flush = true): void;

    /** @throws AlbumNotFound */
    public function update(Album $album, bool $flush = true): void;

    public function search(AlbumId $id): ?Album;

    public function searchOneBy(array $criteria, array $orderBy = null): ?Album;

    /** @return object[]|Album[] */
    public function searchAll(): array;

    /** @return object[]|Album[] */
    public function searchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function countBy(array $criteria): int;

    // todo: refactor bellow methods and include them into any from above
    public function getAll(): AlbumResultSet;

    public function getMatching(Select $select, Criteria $criteria): AlbumResultSet;
}
