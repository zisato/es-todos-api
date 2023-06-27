<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\ExceptionHandler\Strategy;

use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zisato\ApiBundle\Infrastructure\ExceptionHandler\Strategy\ExceptionHandlerStrategyInterface;
use Zisato\ApiBundle\Infrastructure\Service\ResponseServiceInterface;
use Zisato\EventSourcing\Aggregate\Exception\DuplicatedAggregateIdException;

class DuplicatedAggregateIdExceptionHandler implements ExceptionHandlerStrategyInterface
{
    private ResponseServiceInterface $responseService;

    public function __construct(ResponseServiceInterface $responseService)
    {
        $this->responseService = $responseService;
    }

    public function canHandle(Throwable $exception): bool
    {
        return $exception instanceof DuplicatedAggregateIdException;
    }

    public function handle(Throwable $exception): Response
    {
        return $this->responseService->respondValidationError();
    }
}
