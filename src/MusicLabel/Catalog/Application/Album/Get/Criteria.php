<?php

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get;

use Doctrine\Common\Collections\Criteria as CriteriaDoctrine;
use Doctrine\Common\Collections\Expr\Expression;

class Criteria
{
    private CriteriaDoctrine $criteria;
    private string $alias = 'a';

    public function __construct(array $exp, array $sort, int $page, int $size, private array $fields)
    {
        $page = ($page - 1) * $size; // first result
        $this->criteria = new CriteriaDoctrine($this->buildExp($exp), $this->buildSort($sort), $page, $size);
    }

    private function buildExp(array $exp): ?Expression
    {
        if (count($exp) === 0) {
            return null;
        }

        // @todo filters here
        return CriteriaDoctrine::expr()->contains('', []);
    }

    /**
     * @return string[]
     */
    private function buildSort(array $sort): array
    {
        $results = [];
        foreach ($sort as $field) {
            $order = ($field[0] === '-' ? CriteriaDoctrine::DESC : CriteriaDoctrine::ASC);
            $name = ($field[0] === '-' ? substr($field, 1, strlen($field)) : $field);
            $results[$name] = $order;
        }
        return $results;
    }

    public function getCriteria(): CriteriaDoctrine
    {
        return $this->criteria;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string[]
     */
    public function getFieldsToFilter(): array
    {
        return $this->fields;
    }
}
