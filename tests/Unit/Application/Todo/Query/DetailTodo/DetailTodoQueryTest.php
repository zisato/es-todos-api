<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\DetailTodo;

use EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQuery;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQuery
 */
final class DetailTodoQueryTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();

        $query = new DetailTodoQuery($id);

        $this->assertEquals($id, $query->id());
    }
}
