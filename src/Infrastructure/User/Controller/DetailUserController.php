<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Query\DetailUser\DetailUserQuery;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\ReadModel\Service\QueryBus;

class DetailUserController
{
    public function execute(string $id, QueryBus $queryBus, ResponseService $responseService): Response
    {
        $result = $queryBus->ask(new DetailUserQuery($id));

        return $responseService->respondSuccess($result->data());
    }
}
