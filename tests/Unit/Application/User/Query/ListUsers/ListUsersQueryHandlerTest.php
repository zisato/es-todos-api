<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\ListUsers;

use EsTodosApi\Application\User\Query\ListUsers\ListUsersQuery;
use EsTodosApi\Application\User\Query\ListUsers\ListUsersQueryHandler;
use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

/**
 * @covers \EsTodosApi\Application\User\Query\ListUsers\ListUsersQueryHandler
 */
class ListUsersQueryHandlerTest extends TestCase
{
    private UserProjectionRepository|MockObject $userProjectionRepository;
    private ListUsersQueryHandler $queryHandler;

    protected function setUp(): void
    {
        $this->userProjectionRepository = $this->createMock(UserProjectionRepository::class);
        $this->queryHandler = new ListUsersQueryHandler($this->userProjectionRepository);
    }

    public function testShouldCallServiceWithArguments(): void
    {
        $userId1 = UUID::generate();
        $userId2 = UUID::generate();
        $values = [
            UserProjectionModel::create($userId1, Identification::fromValue('User identification 1'), Name::fromValue('User name 1')),
            UserProjectionModel::create($userId2, Identification::fromValue('User identification 2'), Name::fromValue('User name 2'))
        ];
        $collection = ProjectionModelCollection::create(2, $values);
        $this->userProjectionRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($collection);
        $expectedResult = [
            [
                'id' => $userId1->value(),
                'attributes' => [
                    'identification' => 'User identification 1',
                    'name' => 'User name 1',
                ]
            ],
            [
                'id' => $userId2->value(),
                'attributes' => [
                    'identification' => 'User identification 2',
                    'name' => 'User name 2',
                ]
            ]
        ];

        $query = new ListUsersQuery();
        $result = $this->queryHandler->__invoke($query);

        $this->assertEquals($expectedResult, $result->data());
    }
}
