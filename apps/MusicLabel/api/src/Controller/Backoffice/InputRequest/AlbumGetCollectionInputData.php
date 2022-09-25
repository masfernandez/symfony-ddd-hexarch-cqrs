<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;

final class AlbumGetCollectionInputData extends InputDataAbstract
{
    private int $defaultPage = 1;
    private int $defaultSize = 20;
    private string $defaultSort = 'title,release_date,price';
    private string $defaultFields = 'id,title,release_date,price';
    private array $defaultFilters = []; //@todo looking for the best filter approach

    private int $maxSize = 100;

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
        $query  = $request->query->all();
        $page   = $query['page'] ?? [];
        $sort   = $query['sort'] ?? '';
        $fields = $query['fields'] ?? [];
        $filter = $query['filter'] ?? [];

        $number = empty($page['number']) ? $this->defaultPage : $page['number'];
        $number = (int)($number ?? $this->defaultPage);

        $size = empty($page['size']) ? $this->defaultSize : $page['size'];
        $size = (int)($size ?? $this->defaultSize);

        $sort = empty($sort) ? $this->defaultSort : $sort;
        $sort = explode(',', (string)$sort);

        $fields = empty($fields['albums']) ? $this->defaultFields : $fields['albums'];
        $fields = explode(',', (string)$fields);

        // @todo filters here
        $filters = $filter ?? $this->defaultFilters;

        $parameters = [
            'number' => $number,
            'size'   => $size,
            'sort'   => $sort,
            'fields' => $fields,
            'filter' => $filters,
        ];

        $criteriaConstrains = new Constraints\Collection(
            [
                'fields' => [
                    'number' => new Constraints\Range(['min' => 1]),
                    'size'   => new Constraints\Range(['min' => 1, 'max' => $this->maxSize]),
                    'sort'   => [
                        new Constraints\Callback(
                            function (array $fields, ExecutionContextInterface $context): void {
                                foreach ($fields as $field) {
                                    $field = $field[0] !== '-' ? $field : substr($field, 1, strlen($field));
                                    if (!array_key_exists($field, AlbumAssembler::$jsonMappingToEntity)) {
                                        // phpcs:ignore
                                        $context->buildViolation(
                                            "Invalid field to sort: '$field'. Allowed fields: " . implode(
                                                ', ',
                                                array_keys(AlbumAssembler::$jsonMappingToEntity)
                                            )
                                        )
                                            ->atPath($field)
                                            ->addViolation();
                                    }
                                }
                            }
                        )
                    ],
                    'fields' => [
                        new Constraints\Callback(
                            function (array $fields, ExecutionContextInterface $context): void {
                                foreach ($fields as $field) {
                                    if (!array_key_exists($field, AlbumAssembler::$jsonMappingToEntity)) {
                                        // phpcs:ignore
                                        $context->buildViolation(
                                            "Invalid field to include: '$field'. Allowed fields: " . implode(
                                                ', ',
                                                array_keys(AlbumAssembler::$jsonMappingToEntity)
                                            )
                                        )
                                            ->atPath($field)
                                            ->addViolation();
                                    }
                                }
                            }
                        )
                    ],
                    'filter' => [
                        new Constraints\Type('array'),
                        new Constraints\Callback(
                            function (array $filters, ExecutionContextInterface $context): void {
                                foreach (array_keys($filters) as $filter) {
                                    if (!array_key_exists($filter, AlbumAssembler::$jsonMappingToEntity)) {
                                        // phpcs:ignore
                                        $context->buildViolation(
                                            "Invalid filter field: '$filter'. Allowed fields: " . implode(
                                                ', ',
                                                array_keys(AlbumAssembler::$jsonMappingToEntity)
                                            )
                                        )
                                            ->atPath($filter)
                                            ->addViolation();
                                    }
                                }
                            }
                        )
                    ],
                ]
            ]
        );

        $violations = Validation::createValidator()->validate($parameters, $criteriaConstrains);

        if ($violations->count() === 0) {
            $this->page    = $number;
            $this->size    = $size;
            $this->fields  = array_map(static function ($field) {
                return AlbumAssembler::$jsonMappingToEntity[$field];
            }, $fields);
            $this->filters = array_map(static function ($filter) {
                return AlbumAssembler::$jsonMappingToEntity[$filter];
            }, $filters);
            $this->sort    = array_map(static function ($sort): string {
                $order = '';
                if (str_starts_with($sort, '-')) {
                    $order = '-';
                    $sort  = substr($sort, 1, strlen($sort));
                }
                return $order . AlbumAssembler::$jsonMappingToEntity[$sort];
            }, $sort);
        }

        return $violations;
    }
}
