<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Controller;

use EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQuery;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\ReadModel\Service\QueryBus;

class DetailTodoController
{
    public function execute(string $id, QueryBus $queryBus, ResponseService $responseService): Response
    {
        $result = $queryBus->ask(new DetailTodoQuery($id));

        return $responseService->respondSuccess($result->data());
    }
}
