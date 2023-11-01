<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\DetailTodo;

use EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQueryResult;
use EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Query\DetailTodo\DetailTodoQueryResult
 */
final class DetailTodoQueryResultTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate();
        $userId = UUID::generate();
        $title = Title::fromValue('Todo title');
        $description = Description::fromValue('Todo description');
        $projectionModel = TodoProjectionModel::create($id, $userId, $title, $description);
        $transformer = new TodoJsonApiTransformer();

        $queryResult = DetailTodoQueryResult::create($projectionModel, $transformer);

        $expectedResult = [
            'id' => $id->value(),
            'attributes' => [
                'title' => 'Todo title',
                'description' => 'Todo description',
            ],
            'relationships' => [
                'user' => [
                    'id' => $userId->value(),
                ],
            ],
        ];
        $this->assertEquals($expectedResult, $queryResult->data());
    }
}
