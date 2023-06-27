<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoTitleChanged;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnTodoTitleChangedUpdateTodoProjection implements EventHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(TodoTitleChanged $event): void
    {
        $todo = $this->todoProjectionRepository->get($event->aggregateId());

        $todo->changeTitle($event->title());

        $this->todoProjectionRepository->save($todo);
    }
}
