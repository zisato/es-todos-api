<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Subscriber;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\WriteModel\Event\UserDeleted;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnUserDeletedRemoveUserProjection implements EventHandler
{
    public function __construct(private readonly UserProjectionRepository $userProjectionRepository) {}

    public function __invoke(UserDeleted $event): void
    {
        $user = $this->userProjectionRepository->get($event->aggregateId());

        $this->userProjectionRepository->delete($user->id());
    }
}
