<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Query\ListTodos;

use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQuery;
use EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQueryResult;
use EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

/**
 * @covers \EsTodosApi\Application\Todo\Query\ListTodos\ListTodosQueryResult
 */
final class ListTodosQueryResultTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate();
        $userId = UUID::generate();
        $title = Title::fromValue('title');
        $description = Description::fromValue('description');
        $page = 1;
        $perPage = 10;
        $collection = ProjectionModelCollection::create(1, [TodoProjectionModel::create($id, $userId, $title, $description)]);
        $transformer = new TodoJsonApiTransformer();

        $queryResult = ListTodosQueryResult::create($collection, $transformer, $page, $perPage);

        $expectedResult = [
            [
                'id' => $id->value(),
                'attributes' => [
                    'title' => 'title',
                    'description' => 'description',
                ],
                'relationships' => [
                    'user' => [
                        'id' => $userId->value(),
                    ],
                ],
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
