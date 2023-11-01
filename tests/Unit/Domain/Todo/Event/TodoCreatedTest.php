<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated
 */
final class TodoCreatedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $userId = UUID::generate();
        $title = Title::fromValue('title');
        $description = Description::fromValue('description');

        $event = TodoCreated::create($aggregateId, $userId, $title, $description);

        $expectedDefaultVersion = 2;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($userId, $event->userId());
        $this->assertEquals($title, $event->title());
        $this->assertEquals($description, $event->description());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }
}
