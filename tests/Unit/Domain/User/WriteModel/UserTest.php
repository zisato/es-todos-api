<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use EsTodosApi\Domain\User\WriteModel\User;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\EventSourcing\Identity\IdentityInterface;

/**
 * @covers \EsTodosApi\Domain\User\WriteModel\User
 */
final class UserTest extends TestCase
{
    /**
     * @dataProvider getCreateSuccessfullyData
     */
    public function testCreateSuccessfully(
        IdentityInterface $aggregateId, 
        Identification $identification,
        Name $name
    ): void {
        $user = User::create($aggregateId, $identification, $name);

        $this->assertEquals($user->id(), $aggregateId);
        $this->assertEquals($user->identification(), $identification);
        $this->assertEquals($user->name(), $name);
    }

    /**
     * @dataProvider getChangeMethodsData
     */
    public function testChangeMethods(string $method, int $expectedCount, array $values): void
    {
        $user = User::create(UUID::generate(), Identification::fromValue('User identification'), Name::fromValue('User name'));
        $user->releaseRecordedEvents();

        foreach ($values as $value) {
            $user->{$method}($value);
        }

        $events = $user->releaseRecordedEvents();

        $this->assertEquals($expectedCount, $events->count());
    }

    public function testDeleteMethod(): void
    {
        $user = User::create(UUID::generate(), Identification::fromValue('User identification'), Name::fromValue('User name'));
        $user->releaseRecordedEvents();

        $expectedCount = 1;

        $user->delete();
        $user->delete();

        $events = $user->releaseRecordedEvents();

        $this->assertEquals($expectedCount, $events->count());
        $this->assertTrue($user->isDeleted());
    }

    public static function getCreateSuccessfullyData(): array
    {
        return [
            [
                UUID::generate(),
                Identification::fromValue('User identification'),
                Name::fromValue('User name'),
            ],
        ];
    }

    public static function getChangeMethodsData(): array
    {
        return [
            [
                'changeName',
                1,
                [
                    Name::fromValue('New User name'),
                    Name::fromValue('New User name'),
                ]
            ],
            [
                'changeName',
                2,
                [
                    Name::fromValue('New User name'),
                    Name::fromValue('New Awesome User name'),
                ]
            ],
        ];
    }
}
