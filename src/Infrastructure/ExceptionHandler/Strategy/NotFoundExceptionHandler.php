<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\ExceptionHandler\Strategy;

use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zisato\ApiBundle\Infrastructure\ExceptionHandler\Strategy\ExceptionHandlerStrategyInterface;
use Zisato\ApiBundle\Infrastructure\Service\ResponseServiceInterface;
use Zisato\EventSourcing\Aggregate\Exception\AggregateRootNotFoundException;
use Zisato\Projection\Exception\ProjectionModelNotFoundException;

final class NotFoundExceptionHandler implements ExceptionHandlerStrategyInterface
{
    public function __construct(
        private readonly ResponseServiceInterface $responseService
    ) {
    }

    public function canHandle(Throwable $exception): bool
    {
        return $exception instanceof AggregateRootNotFoundException ||
            $exception instanceof ProjectionModelNotFoundException;
    }

    public function handle(Throwable $exception): Response
    {
        return $this->responseService->respondNotFound();
    }
}
