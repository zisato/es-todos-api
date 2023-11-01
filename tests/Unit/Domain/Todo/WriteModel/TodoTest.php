<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\Todo\WriteModel;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\EventSourcing\Identity\IdentityInterface;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Todo
 */
class TodoTest extends TestCase
{
    /**
     * @dataProvider getCreateSuccessfullyData
     */
    public function testCreateSuccessfully(
        IdentityInterface $aggregateId, 
        IdentityInterface $userId,
        Title $title,
        ?Description $description
    ): void {
        $todo = Todo::create($aggregateId, $userId, $title, $description);
        
        $this->assertEquals($todo->id(), $aggregateId);
        $this->assertEquals($todo->userId(), $userId);
        $this->assertEquals($todo->title(), $title);
        $this->assertEquals($todo->description(), $description);
    }

    /**
     * @dataProvider getChangeMethodsData
     */
    public function testChangeMethods(string $method, int $expectedCount, array $values): void
    {
        $todo = Todo::create(UUID::generate(), UUID::generate(), Title::fromValue('Todo title'), Description::fromValue('Todo description'));
        $todo->releaseRecordedEvents();

        foreach ($values as $value) {
            $todo->{$method}($value);
        }

        $events = $todo->releaseRecordedEvents();

        $this->assertEquals($expectedCount, $events->count());
    }

    public function testDeleteMethod(): void
    {
        $todo = Todo::create(UUID::generate(), UUID::generate(), Title::fromValue('Todo title'), Description::fromValue('Todo description'));
        $todo->releaseRecordedEvents();
        $expectedCount = 1;

        $todo->delete();
        $todo->delete();
        $events = $todo->releaseRecordedEvents();

        $this->assertEquals($expectedCount, $events->count());
        $this->assertTrue($todo->isDeleted());
    }

    public static function getCreateSuccessfullyData(): array
    {
        return [
            [
                UUID::generate(),
                UUID::generate(),
                Title::fromValue('Todo title'),
                Description::fromValue('Todo description'),
            ],
            [
                UUID::generate(),
                UUID::generate(),
                Title::fromValue('Todo title'),
                null,
            ],
        ];
    }

    public static function getChangeMethodsData(): array
    {
        return [
            [
                'changeTitle',
                1,
                [
                    Title::fromValue('New Todo title'),
                    Title::fromValue('New Todo title'),
                ]
            ],
            [
                'changeTitle',
                2,
                [
                    Title::fromValue('New Todo title'),
                    Title::fromValue('New Awesome Todo title'),
                ]
            ],
            [
                'changeDescription',
                1,
                [
                    Description::fromValue('New Todo description'),
                    Description::fromValue('New Todo description'),
                ]
            ],
            [
                'changeDescription',
                2,
                [
                    Description::fromValue('New Todo description'),
                    Description::fromValue('New Awesome Todo description'),
                ]
            ],
            [
                'changeDescription',
                2,
                [
                    Description::fromValue('New Todo description'),
                    null,
                ]
            ],
        ];
    }
}
