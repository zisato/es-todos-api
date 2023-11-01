<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Subscriber;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\Event\UserCreated;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

final class OnUserCreatedUpdateUserProjection implements EventHandler
{
    public function __construct(
        private readonly UserProjectionRepository $userProjectionRepository
    ) {
    }

    public function __invoke(UserCreated $event): void
    {
        $user = UserProjectionModel::create(
            UUID::fromString($event->aggregateId()),
            $event->identification(),
            $event->name()
        );

        $this->userProjectionRepository->save($user);
    }
}
