<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\DetailUser;

use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use Zisato\CQRS\ReadModel\Service\QueryHandler;
use Zisato\CQRS\ReadModel\ValueObject\QueryResult;

final class DetailUserQueryHandler implements QueryHandler
{
    public function __construct(private readonly UserProjectionRepository $userProjectionRepository) {}

    public function __invoke(DetailUserQuery $query): QueryResult
    {
        $user = $this->userProjectionRepository->get($query->id());

        return DetailUserQueryResult::create($user, new UserJsonApiTransformer());
    }
}
