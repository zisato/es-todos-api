<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Command\CreateTodo;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\EventSourcing\Identity\IdentityInterface;

class CreateTodoCommandHandler implements CommandHandler
{
    public function __construct(private readonly TodoRepository $todoRepository, private readonly UserRepository $userRepository) {}

    public function __invoke(CreateTodoCommand $command): void
    {
        $userId = UUID::fromString($command->userId());
        $this->assertExistingUserId($userId);

        $description = $command->description() ? Description::fromValue($command->description()) : null;
        $todo = Todo::create(UUID::fromString($command->id()), $userId, Title::fromValue($command->title()), $description);

        $this->todoRepository->save($todo);
    }

    private function assertExistingUserId(IdentityInterface $id): void
    {
        $this->userRepository->get($id);
    }
}
