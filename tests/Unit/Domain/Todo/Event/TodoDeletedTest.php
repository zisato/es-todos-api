<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\Todo\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDeleted;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Event\TodoDeleted
 */
final class TodoDeletedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();

        $event = TodoDeleted::create($aggregateId);

        $expectedDefaultVersion = 1;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }
}
