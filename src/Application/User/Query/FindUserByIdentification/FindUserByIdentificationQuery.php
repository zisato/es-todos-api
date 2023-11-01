<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\FindUserByIdentification;

use Zisato\CQRS\ReadModel\ValueObject\Query;

final class FindUserByIdentificationQuery implements Query
{
    public function __construct(
        private readonly string $identification
    ) {
    }

    public function identification(): string
    {
        return $this->identification;
    }
}
