<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\Todo\Transformer;

use EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer
 */
final class TodoJsonApiTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $id = UUID::generate();
        $userId = UUID::generate();
        $title = Title::fromValue('title');
        $description = Description::fromValue('description');
        $todoProjectionModel = TodoProjectionModel::create($id, $userId, $title, $description);

        $transformer = new TodoJsonApiTransformer();
        $result = $transformer->transform($todoProjectionModel);

        $expectedResult = [
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
        ];
        $this->assertEquals($expectedResult, $result);
    }
}
