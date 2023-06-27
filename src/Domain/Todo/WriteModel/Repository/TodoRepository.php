<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Repository;

use EsTodosApi\Domain\Todo\WriteModel\Todo;
use Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepositoryInterface;
use Zisato\EventSourcing\Identity\IdentityInterface;

interface TodoRepository extends AggregateRootRepositoryInterface
{
    public function get(IdentityInterface $aggregateId): Todo;
}
