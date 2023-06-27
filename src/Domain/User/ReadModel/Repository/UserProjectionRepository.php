<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\ReadModel\Repository;

use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\OrderBy\OrderBy;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

interface UserProjectionRepository
{
    public function findBy(
        ?Criteria $criteria = null,
        ?int $offset = null,
        ?int $limit = null,
        ?OrderBy $orderBy = null
    ): ProjectionModelCollection;

    public function get(string $id): UserProjectionModel;

    public function save(UserProjectionModel $userProjectionModel): void;

    public function delete(string $id): void;
}