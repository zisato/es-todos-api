<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\CreateTodo;

use Zisato\CQRS\WriteModel\ValueObject\Command;

final class CreateTodoCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $userId,
        private readonly string $title,
        private readonly ?string $description
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
