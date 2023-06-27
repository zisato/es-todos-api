<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDescriptionChanged;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnTodoDescriptionChangedUpdateTodoProjection implements EventHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(TodoDescriptionChanged $event): void
    {
        $todo = $this->todoProjectionRepository->get($event->aggregateId());

        $todo->changeDescription($event->description());

        $this->todoProjectionRepository->save($todo);
    }
}
