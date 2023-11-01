<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\FindUserByIdentification;

use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use Zisato\CQRS\ReadModel\Service\QueryHandler;
use Zisato\CQRS\ReadModel\ValueObject\QueryResult;

final class FindUserByIdentificationQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserProjectionRepository $userProjectionRepository
    ) {
    }

    public function __invoke(FindUserByIdentificationQuery $query): QueryResult
    {
        $user = $this->userProjectionRepository->findByIdentification($query->identification());

        return FindUserByIdentificationQueryResult::create($user, new UserJsonApiTransformer());
    }
}
