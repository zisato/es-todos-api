<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Controller;

use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Service\RequestBodyServiceInterface;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

final class CreateTodoController
{
    public function execute(
        RequestBodyServiceInterface $requestBodyService,
        CommandBus $commandBus,
        ResponseService $responseService
    ): Response {
        $requestData = $requestBodyService->requestBody('todo/create.json');

        $command = new CreateTodoCommand(
            $requestData['data']['id'],
            $requestData['data']['relationships']['user']['id'],
            $requestData['data']['attributes']['title'],
            $requestData['data']['attributes']['description'] ?? null
        );

        $commandBus->handle($command);

        return $responseService->respondCreated();
    }
}
