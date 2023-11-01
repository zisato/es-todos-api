<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\ListTodos;

use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQuery;
use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQueryHandler;
use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

/**
 * @covers \EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQueryHandler
 */
class ListTodosQueryHandlerTest extends TestCase
{
    private TodoProjectionRepository|MockObject $todoProjectionRepository;
    private ListTodosQueryHandler $queryHandler;

    protected function setUp(): void
    {
        $this->todoProjectionRepository = $this->createMock(TodoProjectionRepository::class);
        $this->queryHandler = new ListTodosQueryHandler($this->todoProjectionRepository);
    }

    public function testShouldCallServiceWithArguments(): void
    {
        $todoId1 = UUID::generate();
        $todoId2 = UUID::generate();
        $userId = UUID::fromString('448dc3d7-0d74-49d1-98a3-2280aab88d8f');
        $values = [
            TodoProjectionModel::create($todoId1, $userId, Title::fromValue('Todo title 1'), Description::fromValue('Todo description 1')),
            TodoProjectionModel::create($todoId2, $userId, Title::fromValue('Todo title 2'), Description::fromValue('Todo description 2'))
        ];
        $collection = ProjectionModelCollection::create(2, $values);
        $this->todoProjectionRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($collection);
        $expectedResult = [
            [
                'id' => $todoId1->value(),
                'attributes' => [
                    'title' => 'Todo title 1',
                    'description' => 'Todo description 1',
                ],
                'relationships' => [
                    'user' => [
                        'id' => '448dc3d7-0d74-49d1-98a3-2280aab88d8f'
                    ]
                ]
            ],
            [
                'id' => $todoId2->value(),
                'attributes' => [
                    'title' => 'Todo title 2',
                    'description' => 'Todo description 2',
                ],
                'relationships' => [
                    'user' => [
                        'id' => '448dc3d7-0d74-49d1-98a3-2280aab88d8f'
                    ]
                ]
            ]
        ];

        $query = new ListTodosQuery();
        $result = $this->queryHandler->__invoke($query);

        $this->assertEquals($expectedResult, $result->data());
    }
}
