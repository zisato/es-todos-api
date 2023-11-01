<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\ExceptionHandler;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zisato\ApiBundle\Infrastructure\ExceptionHandler\ExceptionHandlerServiceInterface;

final class LoggerExceptionHandlerService implements ExceptionHandlerServiceInterface
{
    public function __construct(
        private readonly ExceptionHandlerServiceInterface $exceptionHandlerService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function handle(Throwable $exception): Response
    {
        $this->logger->error($exception->getMessage(), [
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        return $this->exceptionHandlerService->handle($exception);
    }
}
