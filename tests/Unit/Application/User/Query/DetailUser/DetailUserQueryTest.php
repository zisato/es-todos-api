<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\DetailUser;

use EsTodosApi\Application\User\Query\DetailUser\DetailUserQuery;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Query\DetailUser\DetailUserQuery
 */
final class DetailUserQueryTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();

        $query = new DetailUserQuery($id);

        $this->assertEquals($id, $query->id());
    }
}
