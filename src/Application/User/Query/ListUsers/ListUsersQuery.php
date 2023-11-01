<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\ListUsers;

use Zisato\CQRS\ReadModel\ValueObject\ListableQuery;

final class ListUsersQuery implements ListableQuery
{
    /**
     * @var int
     */
    private const DEFAULT_PAGE = 1;

    /**
     * @var int
     */
    private const DEFAULT_PER_PAGE = 20;

    private readonly int $page;

    private readonly int $perPage;

    public function __construct(?int $page = null, ?int $perPage = null)
    {
        $this->page = $page ?? self::DEFAULT_PAGE;
        $this->perPage = $perPage ?? self::DEFAULT_PER_PAGE;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
