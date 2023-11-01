<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDescriptionChanged;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Event\TodoDescriptionChanged
 */
final class TodoDescriptionChangedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $previousDescription = Description::fromValue('description');
        $newDescription = Description::fromValue('new description');

        $event = TodoDescriptionChanged::create($aggregateId, $previousDescription, $newDescription);

        $expectedDefaultVersion = 1;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($newDescription, $event->description());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }
}
