<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Service\RequestBodyServiceInterface;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\WriteModel\Service\CommandBus;

final class CreateUserController
{
    public function execute(
        RequestBodyServiceInterface $requestBodyService,
        CommandBus $commandBus,
        ResponseService $responseService
    ): Response {
        $requestData = $requestBodyService->requestBody('user/create.json');

        $command = new CreateUserCommand(
            $requestData['data']['id'],
            $requestData['data']['attributes']['identification'],
            $requestData['data']['attributes']['name']
        );

        $commandBus->handle($command);

        return $responseService->respondCreated();
    }
}
