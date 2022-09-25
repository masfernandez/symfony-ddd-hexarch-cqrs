<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelNotFound;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;

interface LabelRepository
{
    /** @throws LabelAlreadyExists */
    public function add(Label $label, bool $flush = true): void;

    public function remove(Label $label, bool $flush = true): void;

    /** @throws LabelNotFound */
    public function update(Label $label, bool $flush = true): void;

    public function search(LabelId $id): ?Label;

    public function searchOneBy(array $criteria, array $orderBy = null): ?Label;

    /** @return object[]|Label[] */
    public function searchAll(): array;

    /** @return object[]|Label[] */
    public function searchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function countBy(array $criteria): int;
}
