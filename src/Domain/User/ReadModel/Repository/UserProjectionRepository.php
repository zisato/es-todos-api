<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\ReadModel\Repository;

use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

interface UserProjectionRepository
{
    public function findAll(int $offset, int $limit): ProjectionModelCollection;

    public function findByIdentification(string $identification): ?UserProjectionModel;

    public function get(string $id): UserProjectionModel;

    public function save(UserProjectionModel $userProjectionModel): void;

    public function delete(string $id): void;
}