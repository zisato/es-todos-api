<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDeleted;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnTodoDeletedRemoveTodoProjection implements EventHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(TodoDeleted $event): void
    {
        $todo = $this->todoProjectionRepository->get($event->aggregateId());

        $this->todoProjectionRepository->delete($todo->id());
    }
}
