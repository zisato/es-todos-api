<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\WriteModel\Repository;

use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepositoryWithSnapshot;
use Zisato\EventSourcing\Identity\IdentityInterface;

class DBALTodoRepository extends AggregateRootRepositoryWithSnapshot implements TodoRepository
{
    public function get(IdentityInterface $aggregateId): Todo
    {
        /** @var Todo $result */
        $result = parent::get($aggregateId);

        return $result;
    }
}
