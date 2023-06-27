<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Query\DetailTodo;

use Zisato\CQRS\ReadModel\ValueObject\Query;

final class DetailTodoQuery implements Query
{
    public function __construct(private readonly string $id) {}

    public function id(): string
    {
        return $this->id;
    }
}
