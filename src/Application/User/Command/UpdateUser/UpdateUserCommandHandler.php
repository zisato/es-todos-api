<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\UpdateUser;

use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\CQRS\WriteModel\Service\CommandHandler;

class UpdateUserCommandHandler implements CommandHandler
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function __invoke(UpdateUserCommand $command): void
    {
        $id = UUID::fromString($command->id());

        $user = $this->userRepository->get($id);

        $user->changeName(Name::fromValue($command->name()));

        $this->userRepository->save($user);
    }
}
