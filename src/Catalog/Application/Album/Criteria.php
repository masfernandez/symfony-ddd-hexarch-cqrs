<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album;

use Doctrine\Common\Collections\Criteria as CriteriaDoctrine;
use Doctrine\Common\Collections\Expr\Expression;

class Criteria
{
    private readonly CriteriaDoctrine $criteria;

    public function __construct(
        array $exp,
        array $sort,
        int $page,
        int $size,
        private readonly ?string $alias = 'a'
    ) {
        $page           = ($page - 1) * $size; // first result
        $this->criteria = new CriteriaDoctrine($this->buildExp($exp), $this->buildSort($sort), $page, $size);
    }

    private function buildExp(array $exp): ?Expression
    {
        if ($exp === []) {
            return null;
        }

        // @todo filters here
        return CriteriaDoctrine::expr()?->contains('', []);
    }

    /**
     * @return string[]
     */
    private function buildSort(array $sort): array
    {
        $results = [];
        foreach ($sort as $field) {
            $order          = ($field[0] === '-' ? CriteriaDoctrine::DESC : CriteriaDoctrine::ASC);
            $name           = ($field[0] === '-' ? substr($field, 1, strlen((string) $field)) : $field);
            $results[$name] = $order;
        }
        return $results;
    }

    public function getCriteria(): CriteriaDoctrine
    {
        return $this->criteria;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }
}
