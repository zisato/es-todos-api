<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Controller;

use EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Service\RequestBodyServiceInterface;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

class UpdateTodoController
{
    public function execute(string $id, RequestBodyServiceInterface $requestBodyService, CommandBus $commandBus, ResponseService $responseService): Response
    {
        $requestData = $requestBodyService->requestBody('todo/update.json');

        $command = new UpdateTodoCommand(
            $id,
            $requestData['data']['attributes']['title'],
            $requestData['data']['attributes']['description'] ?? null
        );

        $commandBus->handle($command);

        return $responseService->respondUpdated();
    }
}
