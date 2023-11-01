<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\ListTodos;

use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQuery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQuery
 */
final class ListTodosQueryTest extends TestCase
{
    public function testCreate(): void
    {
        $page = 1;
        $perPage = 10;

        $query = new ListTodosQuery($page, $perPage);

        $this->assertEquals($page, $query->page());
        $this->assertEquals($perPage, $query->perPage());
    }
}
