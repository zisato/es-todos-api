<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\ListUsers;

use EsTodosApi\Application\User\Query\ListUsers\ListUsersQuery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Application\User\Query\ListUsers\ListUsersQuery
 */
final class ListUsersQueryTest extends TestCase
{
    public function testCreate(): void
    {
        $page = 1;
        $perPage = 10;

        $query = new ListUsersQuery($page, $perPage);

        $this->assertEquals($page, $query->page());
        $this->assertEquals($perPage, $query->perPage());
    }
}
