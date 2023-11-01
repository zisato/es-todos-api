<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Controller;

use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

final class DeleteTodoController
{
    public function execute(string $id, CommandBus $commandBus, ResponseService $responseService): Response
    {
        $command = new DeleteTodoCommand($id);

        $commandBus->handle($command);

        return $responseService->respondDeleted();
    }
}
