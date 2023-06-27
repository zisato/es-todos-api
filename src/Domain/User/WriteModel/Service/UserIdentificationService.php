<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\Service;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;

interface UserIdentificationService
{
    public function existsIdentification(Identification $identification): bool;
}
