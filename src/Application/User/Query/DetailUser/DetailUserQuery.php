<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\DetailUser;

use Zisato\CQRS\ReadModel\ValueObject\Query;

final class DetailUserQuery implements Query
{
    public function __construct(
        private readonly string $id
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
