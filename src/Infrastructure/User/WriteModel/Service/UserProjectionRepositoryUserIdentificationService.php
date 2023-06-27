<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\WriteModel\Service;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\WriteModel\Service\UserIdentificationService;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use Zisato\Projection\Criteria\Condition;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\Criteria\CriteriaItem;

final class UserProjectionRepositoryUserIdentificationService implements UserIdentificationService
{
    public function __construct(private readonly UserProjectionRepository $userProjectionRepository) {}

    public function existsIdentification(Identification $identification): bool
    {
        $collection = $this->userProjectionRepository->findBy(
            new Criteria(new CriteriaItem('identification', $identification->value(), Condition::like())),
            0,
            1
        );

        return $collection->total() > 0;
    }
}
