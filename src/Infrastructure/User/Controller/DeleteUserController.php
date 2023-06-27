<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

class DeleteUserController
{
    public function execute(string $id, CommandBus $commandBus, ResponseService $responseService): Response
    {
        $command = new DeleteUserCommand($id);

        $commandBus->handle($command);

        return $responseService->respondDeleted();
    }
}
