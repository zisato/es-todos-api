<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Query\ListTodos;

use Zisato\CQRS\ReadModel\ValueObject\ListableQueryResult;
use Zisato\Projection\Transformer\ProjectionModelTransformer;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

class ListTodosQueryResult implements ListableQueryResult
{
    /**
     * @param array<int, mixed> $data
     */
    private function __construct(
        private readonly array $data,
        private readonly int $totalItems,
        private readonly int $page,
        private readonly int $perPage,
        private readonly int $totalPages
    ) {}

    public static function create(
        ProjectionModelCollection $collection,
        ProjectionModelTransformer $transformer,
        int $page,
        int $perPage
    ): ListTodosQueryResult {
        /** @var array<int, mixed> $data */
        $data = [];
        foreach ($collection->data() as $projectionModel) {
            $data[] = $transformer->transform($projectionModel);
        }

        $totalItems = $collection->total();
        $totalPages = (int) \ceil($totalItems / $perPage);

        return new ListTodosQueryResult($data, $totalItems, $page, $perPage, $totalPages);
    }

    public function data(): array
    {
        return $this->data;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }

    public function totalItems(): int
    {
        return $this->totalItems;
    }
}
