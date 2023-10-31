<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\Event\UserDeleted;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;

final class OnUserDeletedRemoveTodoProjections implements EventHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(UserDeleted $event): void
    {
        $collection = $this->todoProjectionRepository->findByUserId($event->aggregateId());

        /** @var UserProjectionModel $user */
        foreach ($collection->data() as $user) {
            $this->todoProjectionRepository->delete($user->id());
        }
    }
}
