<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\User\WriteModel\Event\UserNameChanged;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\User\WriteModel\Event\UserNameChanged
 */
final class UserNameChangedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $previousName = Name::fromValue('name');
        $newName = Name::fromValue('new name');

        $event = UserNameChanged::create($aggregateId, $previousName, $newName);

        $expectedDefaultVersion = 1;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($newName, $event->name());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }
}
