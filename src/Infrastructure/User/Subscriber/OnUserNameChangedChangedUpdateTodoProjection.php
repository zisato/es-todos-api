<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Subscriber;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\WriteModel\Event\UserNameChanged;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnUserNameChangedChangedUpdateTodoProjection implements EventHandler
{
    public function __construct(private readonly UserProjectionRepository $userProjectionRepository) {}

    public function __invoke(UserNameChanged $event): void
    {
        $user = $this->userProjectionRepository->get($event->aggregateId());

        $user->changeName($event->name());

        $this->userProjectionRepository->save($user);
    }
}
