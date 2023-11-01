<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\CreateUser;

use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = User::create(UUID::fromString($command->id()), Identification::fromValue($command->identification()), Name::fromValue($command->name()));

        $this->userRepository->save($user);
    }
}
