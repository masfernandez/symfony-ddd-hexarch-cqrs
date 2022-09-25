<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\Exceptions\TrackAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\Exceptions\TrackNotFound;
use Masfernandez\MusicLabel\Shared\Domain\Id\TrackId;

interface TrackRepository
{
    /** @throws TrackAlreadyExists */
    public function add(Track $track, bool $flush = true): void;

    public function remove(Track $track, bool $flush = true): void;

    /** @throws TrackNotFound */
    public function update(Track $track, bool $flush = true): void;

    public function search(TrackId $id): ?Track;

    public function searchOneBy(array $criteria, array $orderBy = null): ?Track;

    /** @return object[]|Track[] */
    public function searchAll(): array;

    /** @return object[]|Track[] */
    public function searchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function countBy(array $criteria): int;
}
