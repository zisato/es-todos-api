<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class OnTodoCreatedUpdateTodoProjection implements EventHandler
{
    private TodoProjectionRepository $todoProjectionRepository;

    public function __construct(TodoProjectionRepository $todoProjectionRepository)
    {
        $this->todoProjectionRepository = $todoProjectionRepository;
    }

    public function __invoke(TodoCreated $event): void
    {
        $todo = TodoProjectionModel::create(UUID::fromString($event->aggregateId()), $event->userId(), $event->title(), $event->description());

        $this->todoProjectionRepository->save($todo);
    }
}
