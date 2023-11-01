<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\DeleteTodo;

use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand
 */
final class DeleteTodoCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();

        $command = new DeleteTodoCommand($id);
        
        $this->assertEquals($id, $command->id());
    }
}
