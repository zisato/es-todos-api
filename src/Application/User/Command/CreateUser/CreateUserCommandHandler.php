<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Command\CreateUser;

use EsTodosApi\Domain\User\WriteModel\Service\UserIdentificationService;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use InvalidArgumentException;
use Zisato\CQRS\WriteModel\Service\CommandHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\EventSourcing\Aggregate\Exception\AggregateRootNotFoundException;
use Zisato\EventSourcing\Aggregate\Exception\DuplicatedAggregateIdException;
use Zisato\EventSourcing\Identity\IdentityInterface;

class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(private readonly UserIdentificationService $userIdentificationService, private readonly UserRepository $userRepository) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $id = UUID::fromString($command->id());
        $this->assertDuplicatedUserId($id);

        $identification = Identification::fromValue($command->identification());
        $this->assertDuplicatedUserIdentification($identification);

        $user = User::create($id, $identification, Name::fromValue($command->name()));

        $this->userRepository->save($user);
    }
    
    private function assertDuplicatedUserId(IdentityInterface $id): void
    {
        try {
            $this->userRepository->get($id);

            throw new DuplicatedAggregateIdException(\sprintf(
                'User aggregate id %s exists in repository.',
                $id->value()
            ));
        } catch (AggregateRootNotFoundException $exception) {}
    }

    private function assertDuplicatedUserIdentification(Identification $identification): void
    {
        if ($this->userIdentificationService->existsIdentification($identification)) {
            throw new InvalidArgumentException(
                \sprintf(
                    'User identification %s exists in repository.',
                    $identification->value()
                )
            );
        }
    }
}
