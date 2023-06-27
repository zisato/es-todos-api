<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\DeleteTodo;

use Zisato\EventSourcing\Aggregate\Identity\UUID;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use Zisato\CQRS\WriteModel\Service\CommandHandler;

class DeleteTodoCommandHandler implements CommandHandler
{
    private TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function __invoke(DeleteTodoCommand $command): void
    {
        $id = UUID::fromString($command->id());

        $todo = $this->todoRepository->get($id);

        $todo->delete();

        $this->todoRepository->save($todo);
    }
}
