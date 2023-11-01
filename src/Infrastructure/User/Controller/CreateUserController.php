<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Controller;

use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQuery;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Zisato\ApiBundle\Infrastructure\Service\RequestBodyServiceInterface;
use Zisato\ApiBundle\Infrastructure\Symfony\Service\ResponseService;
use Zisato\CQRS\ReadModel\Service\QueryBus;
use Zisato\CQRS\WriteModel\Service\CommandBus;

final class CreateUserController
{
    public function execute(
        RequestBodyServiceInterface $requestBodyService,
        QueryBus $queryBus,
        CommandBus $commandBus,
        ResponseService $responseService
    ): Response {
        $requestData = $requestBodyService->requestBody('user/create.json');

        $query = new FindUserByIdentificationQuery($requestData['data']['attributes']['identification']);
        $queryResult = $queryBus->ask($query);

        if ($queryResult->data() !== []) {
            throw new InvalidArgumentException(
                sprintf('User identification %s exists in repository.', $requestData['data']['attributes']['identification'])
            );
        }

        $command = new CreateUserCommand(
            $requestData['data']['id'],
            $requestData['data']['attributes']['identification'],
            $requestData['data']['attributes']['name']
        );

        $commandBus->handle($command);

        return $responseService->respondCreated();
    }
}
