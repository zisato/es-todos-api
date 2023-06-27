<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\UpdateTodo;

use Zisato\EventSourcing\Aggregate\Identity\UUID;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use Zisato\CQRS\WriteModel\Service\CommandHandler;

class UpdateTodoCommandHandler implements CommandHandler
{
    private TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function __invoke(UpdateTodoCommand $command): void
    {
        $id = UUID::fromString($command->id());

        $todo = $this->todoRepository->get($id);

        $todo->changeTitle(Title::fromValue($command->title()));

        $newDescription = $command->description() === null ? null : Description::fromValue($command->description());
        $todo->changeDescription($newDescription);

        $this->todoRepository->save($todo);
    }
}
