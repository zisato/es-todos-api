<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\WriteModel\Service;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\Service\UserIdentificationService;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;

final class UserProjectionRepositoryUserIdentificationService implements UserIdentificationService
{
    public function __construct(
        private readonly UserProjectionRepository $userProjectionRepository
    ) {
    }

    public function existsIdentification(Identification $identification): bool
    {
        $userProjection = $this->userProjectionRepository->findByIdentification($identification->value());

        return $userProjection instanceof UserProjectionModel;
    }
}
