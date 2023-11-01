<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\DeleteTodo;

use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand;
use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommandHandler;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand
 */
final class DeleteTodoCommandTest extends TestCase
{
    private TodoRepository|MockObject $todoRepository;
    private DeleteTodoCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->todoRepository = $this->createMock(TodoRepository::class);
        $this->commandHandler = new DeleteTodoCommandHandler($this->todoRepository);
    }

    public function testCreate(): void
    {
        $id = UUID::generate()->value();

        $command = new DeleteTodoCommand($id);
        
        $this->assertEquals($id, $command->id());
    }
}
