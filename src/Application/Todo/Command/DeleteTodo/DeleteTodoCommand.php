<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\DeleteTodo;

use Zisato\CQRS\WriteModel\ValueObject\Command;

final class DeleteTodoCommand implements Command
{
    public function __construct(
        private readonly string $id
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
