<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Controller;

use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\ReadModel\Service\QueryBus;
use Zisato\CQRS\ReadModel\ValueObject\ListableQueryResult;

final class ListTodosController
{
    public function execute(Request $request, QueryBus $queryBus, ResponseService $responseService): Response
    {
        /** @var ListableQueryResult $result */
        $result = $queryBus->ask(new ListTodosQuery(
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
