<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\Todo\ReadModel;

use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel
 */
class TodoProjectionModelTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $userId = UUID::generate();
        $title = Title::fromValue('title');
        $description = Description::fromValue('description');

        $projectionModel = TodoProjectionModel::create($aggregateId, $userId, $title, $description);

        $this->assertEquals($aggregateId->value(), $projectionModel->id());
        $this->assertEquals($userId->value(), $projectionModel->userId());
        $this->assertEquals($title->value(), $projectionModel->title());
        $this->assertEquals($description->value(), $projectionModel->description());
    }

    public function testChangeTitle(): void
    {
        $projectionModel = TodoProjectionModel::create(
            UUID::generate(),
            UUID::generate(),
            Title::fromValue('title'),
            Description::fromValue('description')
        );

        $projectionModel->changeTitle(Title::fromValue('new title'));

        $expectedNewTitle = 'new title';
        $this->assertEquals($expectedNewTitle, $projectionModel->title());
    }

    /**
     * @dataProvider getChangeDescriptionData
     */
    public function testChangeDescription(?Description $newDescription, ?string $expectedDescription): void
    {
        $projectionModel = TodoProjectionModel::create(
            UUID::generate(),
            UUID::generate(),
            Title::fromValue('title'),
            Description::fromValue('description')
        );

        $projectionModel->changeDescription($newDescription);

        $this->assertEquals($expectedDescription, $projectionModel->description());
    }

    public static function getChangeDescriptionData(): array
    {
        return [
            'change to object' => [
                Description::fromValue('new description'),
                'new description',
            ],
            'change to null' => [
                null,
                null,
            ],
        ];
    }
}
