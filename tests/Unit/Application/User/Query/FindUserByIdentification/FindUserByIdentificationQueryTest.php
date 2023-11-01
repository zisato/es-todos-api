<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\FindUserByIdentification;

use EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQuery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQuery
 */
final class FindUserByIdentificationQueryTest extends TestCase
{
    public function testCreate(): void
    {
        $identification = 'User identification';

        $query = new FindUserByIdentificationQuery($identification);

        $this->assertEquals($identification, $query->identification());
    }
}
