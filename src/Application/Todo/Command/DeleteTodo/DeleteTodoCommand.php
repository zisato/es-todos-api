<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\DeleteTodo;

use Zisato\CQRS\WriteModel\ValueObject\Command;

class DeleteTodoCommand implements Command
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
