<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\WriteModel\Repository;

use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepositoryWithSnapshot;
use Zisato\EventSourcing\Identity\IdentityInterface;

class DBALUserRepository extends AggregateRootRepositoryWithSnapshot implements UserRepository
{
    public function get(IdentityInterface $aggregateId): User
    {
        /** @var User $result */
        $result = parent::get($aggregateId);

        return $result;
    }
}
