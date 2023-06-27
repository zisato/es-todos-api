<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\DeleteUser;

use Zisato\CQRS\WriteModel\ValueObject\Command;

class DeleteUserCommand implements Command
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
