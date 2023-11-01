<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\CreateUser;

use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\Service\UserIdentificationService;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use InvalidArgumentException;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserIdentificationService $userIdentificationService,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $identification = Identification::fromValue($command->identification());
        $this->assertDuplicatedUserIdentification($identification);

        $user = User::create(UUID::fromString($command->id()), $identification, Name::fromValue($command->name()));

        $this->userRepository->save($user);
    }

    private function assertDuplicatedUserIdentification(Identification $identification): void
    {
        if ($this->userIdentificationService->existsIdentification($identification)) {
            throw new InvalidArgumentException(
                \sprintf('User identification %s exists in repository.', $identification->value())
            );
        }
    }
}
