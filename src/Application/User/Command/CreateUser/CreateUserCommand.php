<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\CreateUser;

use Zisato\CQRS\WriteModel\ValueObject\Command;

final class CreateUserCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $identification,
        private readonly string $name
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function identification(): string
    {
        return $this->identification;
    }

    public function name(): string
    {
        return $this->name;
    }
}
