<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\ReadModel\Repository;

use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\OrderBy\OrderBy;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

interface TodoProjectionRepository
{
    public function findBy(
        ?Criteria $criteria = null,
        ?int $offset = null,
        ?int $limit = null,
        ?OrderBy $orderBy = null
    ): ProjectionModelCollection;

    public function get(string $id): TodoProjectionModel;

    public function save(TodoProjectionModel $todoProjectionModel): void;

    public function delete(string $id): void;
}