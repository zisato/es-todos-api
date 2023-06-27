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
use Zisato\EventSourcing\Aggregate\Exception\AggregateRootNotFoundException;
use Zisato\EventSourcing\Aggregate\Exception\DuplicatedAggregateIdException;
use Zisato\EventSourcing\Identity\IdentityInterface;

class CreateTodoCommandHandler implements CommandHandler
{
    public function __construct(private readonly TodoRepository $todoRepository, private readonly UserRepository $userRepository) {}

    public function __invoke(CreateTodoCommand $command): void
    {
        $id = UUID::fromString($command->id());
        $this->assertDuplicatedTodoId($id);

        $userId = UUID::fromString($command->userId());
        $this->assertExistingUserId($userId);

        $description = $command->description() ? Description::fromValue($command->description()) : null;
        $todo = Todo::create($id, $userId, Title::fromValue($command->title()), $description);

        $this->todoRepository->save($todo);
    }
    
    private function assertDuplicatedTodoId(IdentityInterface $id): void
    {
        try {
            $this->todoRepository->get($id);

            throw new DuplicatedAggregateIdException(\sprintf(
                'Todo aggregate id %s exists in repository.',
                $id->value()
            ));
        } catch (AggregateRootNotFoundException $exception) {}
    }

    private function assertExistingUserId(IdentityInterface $id): void
    {
        $this->userRepository->get($id);
    }
}
