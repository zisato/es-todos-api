<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\DeleteUser;

use Zisato\CQRS\WriteModel\ValueObject\Command;

final class DeleteUserCommand implements Command
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
