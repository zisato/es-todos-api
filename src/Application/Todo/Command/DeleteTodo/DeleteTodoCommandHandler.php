<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\DeleteTodo;

use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

final class DeleteTodoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly TodoRepository $todoRepository
    ) {
    }

    public function __invoke(DeleteTodoCommand $command): void
    {
        $id = UUID::fromString($command->id());

        $todo = $this->todoRepository->get($id);

        $todo->delete();

        $this->todoRepository->save($todo);
    }
}
