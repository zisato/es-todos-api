<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\Repository;

use EsTodosApi\Domain\User\WriteModel\User;
use Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepositoryInterface;
use Zisato\EventSourcing\Identity\IdentityInterface;

interface UserRepository extends AggregateRootRepositoryInterface
{
    public function get(IdentityInterface $aggregateId): User;
}
