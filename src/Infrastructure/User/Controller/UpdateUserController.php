<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Command\UpdateUser\UpdateUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Service\RequestBodyServiceInterface;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

class UpdateUserController
{
    public function execute(string $id, RequestBodyServiceInterface $requestBodyService, CommandBus $commandBus, ResponseService $responseService): Response
    {
        $requestData = $requestBodyService->requestBody('user/update.json');

        $command = new UpdateUserCommand(
            $id,
            $requestData['data']['attributes']['name']
        );

        $commandBus->handle($command);

        return $responseService->respondUpdated();
    }
}
