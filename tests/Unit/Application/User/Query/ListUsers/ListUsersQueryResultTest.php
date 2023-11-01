<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\ListUsers;

use EsTodosApi\Application\User\Query\ListUsers\ListUsersQueryResult;
use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

/**
 * @covers \EsTodosApi\Application\User\Query\ListUsers\ListUsersQueryResult
 */
final class ListUsersQueryResultTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = Name::fromValue('User name');
        $page = 1;
        $perPage = 10;
        $collection = ProjectionModelCollection::create(1, [UserProjectionModel::create($id, $identification, $name)]);
        $transformer = new UserJsonApiTransformer();

        $queryResult = ListUsersQueryResult::create($collection, $transformer, $page, $perPage);

        $expectedResult = [
            [
                'id' => $id->value(),
                'attributes' => [
                    'identification' => 'User identification',
                    'name' => 'User name',
                ]
            ],
        ];
        $expectedTotalPages = 1;
        $expectedTotalItems = 1;
        $this->assertEquals($expectedResult, $queryResult->data());
        $this->assertEquals($page, $queryResult->page());
        $this->assertEquals($perPage, $queryResult->perPage());
        $this->assertEquals($expectedTotalPages, $queryResult->totalPages());
        $this->assertEquals($expectedTotalItems, $queryResult->totalItems());
    }
}
