<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\UpdateUser;

use Zisato\CQRS\WriteModel\ValueObject\Command;

class UpdateUserCommand implements Command
{
    public function __construct(private readonly string $id, private readonly string $name) {}

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
