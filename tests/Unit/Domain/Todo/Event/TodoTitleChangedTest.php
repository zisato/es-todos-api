<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoTitleChanged;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Event\TodoTitleChanged
 */
final class TodoTitleChangedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $previousTitle = Title::fromValue('title');
        $newTitle = Title::fromValue('new title');

        $event = TodoTitleChanged::create($aggregateId, $previousTitle, $newTitle);

        $expectedDefaultVersion = 1;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($newTitle, $event->title());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }
}
