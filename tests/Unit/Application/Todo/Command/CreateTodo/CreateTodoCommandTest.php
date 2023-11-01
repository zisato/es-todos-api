<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\CreateTodo;

use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand
 */
final class CreateTodoCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();
        $userId = UUID::generate()->value();
        $title = 'title';
        $description = 'description';

        $command = new CreateTodoCommand($id, $userId, $title, $description);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($userId, $command->userId());
        $this->assertEquals($title, $command->title());
        $this->assertEquals($description, $command->description());
    }
}
