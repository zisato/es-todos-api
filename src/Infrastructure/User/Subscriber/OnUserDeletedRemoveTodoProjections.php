<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\Subscriber;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\Event\UserDeleted;
use EsTodosApi\Infrastructure\MessageHandler\EventHandler;
use Zisato\Projection\Criteria\Condition;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\Criteria\CriteriaItem;

final class OnUserDeletedRemoveTodoProjections implements EventHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(UserDeleted $event): void
    {
        $collection = $this->todoProjectionRepository->findBy(new Criteria(new CriteriaItem('userId', $event->aggregateId(), Condition::eq())));

        /** @var UserProjectionModel $user */
        foreach ($collection->data() as $user) {
            $this->todoProjectionRepository->delete($user->id());
        }
    }
}
