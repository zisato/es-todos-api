<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\UpdateTodo;

use EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommand
 */
final class UpdateTodoCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();
        $title = 'new title';
        $description = 'new descrition';

        $command = new UpdateTodoCommand($id, $title, $description);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($title, $command->title());
        $this->assertEquals($description, $command->description());
    }
}
