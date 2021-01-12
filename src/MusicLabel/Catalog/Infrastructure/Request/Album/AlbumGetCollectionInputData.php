<?php

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album;

use Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;

final class AlbumGetCollectionInputData extends InputDataAbstract
{
    private array $valid_fields = ['id', 'title', 'publishing_date'];

    private int $default_page = 1;
    private int $default_size = 20;
    private int $max_size = 100;
    private string $default_sort = 'title,publishing_date';
    private string $default_fields = 'id,title,publishing_date';
    private array $default_filters = []; //@todo looking for the best filter approach

    private int $page;
    private int $size;
    private array $sort;
    private array $fields;
    private array $filters;

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return mixed[]
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * @return mixed[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return mixed[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $q = $request->query->all();

        $numberQ = (isset($q['page']['number']) && $q['page']['number'] !== '') ? $q['page']['number'] : $this->default_page;
        $number = (int)($numberQ ?? $this->default_page);

        $sizeQ = (isset($q['page']['size']) && $q['page']['size'] !== '') ? $q['page']['size'] : $this->default_size;
        $size = (int)($sizeQ ?? $this->default_size);

        $sortQ = (isset($q['sort']) && $q['sort'] !== '') ? $q['sort'] : $this->default_sort;
        $sort = explode(',', $sortQ);

        $fieldsQ = (isset($q['fields']['albums']) && $q['fields']['albums'] !== '') ? $q['fields']['albums'] : $this->default_fields;
        $fields = explode(',', $fieldsQ);

        // @todo filters here
        $filters = $q['filter'] ?? $this->default_filters;

        $parameters = [
            'number' => $number,
            'size' => $size,
            'sort' => $sort,
            'fields' => $fields,
            'filter' => $filters,
        ];

        $criteriaConstrains = new Constraints\Collection(['fields' => [
            'number' => new Assert\Range(['min' => 1]),
            'size' => new Assert\Range(['min' => 1, 'max' => $this->max_size]),
            'sort' => [
                new Assert\Callback(function (array $fields, ExecutionContextInterface $context): void {
                    foreach ($fields as $field) {
                        $field = $field[0] !== '-' ? $field : substr($field, 1, strlen($field));
                        if (!in_array($field, $this->valid_fields, true)) {
                            $context->buildViolation("Invalid field to sort: '$field'. Allowed fields: " . implode(', ', $this->valid_fields))
                                ->atPath($field)
                                ->addViolation();
                        }
                    }
                })
            ],
            'fields' => [
                new Assert\Callback(function (array $fields, ExecutionContextInterface $context): void {
                    foreach ($fields as $field) {
                        if (!in_array($field, $this->valid_fields, true)) {
                            $context->buildViolation("Invalid field to include: '$field'. Allowed fields: " . implode(', ', $this->valid_fields))
                                ->atPath($field)
                                ->addViolation();
                        }
                    }
                })
            ],
            'filter' => [
                new Assert\Type('array'),
                new Assert\Callback(function (array $filters, ExecutionContextInterface $context): void {
                    foreach (array_keys($filters) as $filter) {
                        if (!in_array($filter, $this->valid_fields, true)) {
                            $context->buildViolation("Invalid filter field: '$filter'. Allowed fields: " . implode(', ', $this->valid_fields))
                                ->atPath($filter)
                                ->addViolation();
                        }
                    }
                })
            ],
        ]]);

        $violations = Validation::createValidator()->validate($parameters, $criteriaConstrains);

        if ($violations->count() === 0) {
            $this->page = $number;
            $this->size = $size;
            $this->fields = $fields;
            $this->filters = $filters;
            $this->sort = $sort;
        }

        return $violations;
    }
}
