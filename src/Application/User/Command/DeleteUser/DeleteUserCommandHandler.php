<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\DeleteUser;

use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

final class DeleteUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $id = UUID::fromString($command->id());

        $user = $this->userRepository->get($id);

        $user->delete();

        $this->userRepository->save($user);
    }
}
