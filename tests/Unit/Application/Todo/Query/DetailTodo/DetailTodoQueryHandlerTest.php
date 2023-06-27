<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\DetailTodo;

use EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQuery;
use EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQueryHandler;
use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class DetailTodoQueryHandlerTest extends TestCase
{
    /** @var TodoProjectionRepository|MockObject $todoProjectionRepository */
    private $todoProjectionRepository;
    private DetailTodoQueryHandler $queryHandler;

    protected function setUp(): void
    {
        $this->todoProjectionRepository = $this->createMock(TodoProjectionRepository::class);
        $this->queryHandler = new DetailTodoQueryHandler($this->todoProjectionRepository);
    }

    public function testShouldCallServiceWithArguments(): void
    {
        $id = UUID::generate();
        $userId = UUID::fromString('448dc3d7-0d74-49d1-98a3-2280aab88d8f');
        $title = Title::fromValue('Todo title');
        $description = Description::fromValue('Todo description');
        $todoProjection = TodoProjectionModel::create($id, $userId, $title, $description);
        $this->todoProjectionRepository->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($id->value()),
            )
            ->willReturn($todoProjection);
        $expectedResult = [
            'id' => $id->value(),
            'attributes' => [
                'title' => 'Todo title',
                'description' => 'Todo description',
            ],
            'relationships' => [
                'user' => [
                    'id' => '448dc3d7-0d74-49d1-98a3-2280aab88d8f'
                ]
            ]
        ];

        $query = new DetailTodoQuery($id->value());
        $result = $this->queryHandler->__invoke($query);

        $this->assertEquals($expectedResult, $result->data());
    }
}
