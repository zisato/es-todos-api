<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\ListUsers;

use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use Zisato\CQRS\ReadModel\Service\QueryHandler;

final class ListUsersQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserProjectionRepository $userProjectionRepository
    ) {
    }

    public function __invoke(ListUsersQuery $query): ListUsersQueryResult
    {
        $offset = (($query->page() - 1) * $query->perPage());

        $usersCollection = $this->userProjectionRepository->findAll($offset, $query->perPage());

        return ListUsersQueryResult::create(
            $usersCollection,
            new UserJsonApiTransformer(),
            $query->page(),
            $query->perPage()
        );
    }
}
