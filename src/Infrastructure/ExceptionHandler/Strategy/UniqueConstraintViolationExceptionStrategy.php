<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\ExceptionHandler\Strategy;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zisato\ApiBundle\Infrastructure\ExceptionHandler\Strategy\ExceptionHandlerStrategyInterface;
use Zisato\ApiBundle\Infrastructure\Service\ResponseServiceInterface;

final class UniqueConstraintViolationExceptionStrategy implements ExceptionHandlerStrategyInterface
{
    public function __construct(
        private readonly ResponseServiceInterface $responseService
    ) {
    }

    public function canHandle(Throwable $exception): bool
    {
        return $exception instanceof UniqueConstraintViolationException;
    }

    public function handle(Throwable $exception): Response
    {
        return $this->responseService->respondValidationError();
    }
}
