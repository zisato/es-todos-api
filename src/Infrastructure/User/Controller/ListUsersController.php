<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Query\ListUsers\ListUsersQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\ReadModel\Service\QueryBus;
use Zisato\CQRS\ReadModel\ValueObject\ListableQueryResult;

final class ListUsersController
{
    public function execute(Request $request, QueryBus $queryBus, ResponseService $responseService): Response
    {
        /** @var ListableQueryResult $result */
        $result = $queryBus->ask(new ListUsersQuery(
            $request->query->has('page') ? $request->query->getInt('page') : null,
            $request->query->has('perPage') ? $request->query->getInt('perPage') : null
        ));

        return $responseService->respondCollection(
            $result->data(),
            $result->totalItems(),
            $result->page(),
            $result->perPage(),
            $result->totalPages()
        );
    }
}
