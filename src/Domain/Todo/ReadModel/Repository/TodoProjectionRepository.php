<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\ReadModel\Repository;

use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

interface TodoProjectionRepository
{
    public function findAll(int $offset, int $limit): ProjectionModelCollection;

    public function findByUserId(string $user): ProjectionModelCollection;

    public function get(string $id): TodoProjectionModel;

    public function save(TodoProjectionModel $todoProjectionModel): void;

    public function delete(string $id): void;
}
