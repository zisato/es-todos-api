<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\ExceptionHandler\Strategy;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Zisato\ApiBundle\Infrastructure\ExceptionHandler\Strategy\ExceptionHandlerStrategyInterface;
use Zisato\ApiBundle\Infrastructure\Service\ResponseServiceInterface;

final class NotFoundHttpExceptionStrategy implements ExceptionHandlerStrategyInterface
{
    public function __construct(
        private readonly ResponseServiceInterface $responseService
    ) {
    }

    public function canHandle(Throwable $exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    public function handle(Throwable $exception): Response
    {
        return $this->responseService->respondNotFound();
    }
}
