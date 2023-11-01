<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\UpdateTodo;

use EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommand;
use EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommandHandler;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\UpdateTodo\UpdateTodoCommandHandler
 */
final class UpdateTodoCommandHandlerTest extends TestCase
{
    private TodoRepository|MockObject $todoRepository;

    private UpdateTodoCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->todoRepository = $this->createMock(TodoRepository::class);
        $this->commandHandler = new UpdateTodoCommandHandler($this->todoRepository);
    }

    public function testShouldUpdateTodo(): void
    {
        $id = UUID::generate();
        $userId = UUID::generate();
        $todo = Todo::create($id, $userId, Title::fromValue('Todo title'), Description::fromValue('Todo description'));
        $newTitle = 'New Todo title';
        $newDescription = 'New Todo description';
        $this->todoRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($id))
            ->willReturn($todo);

        $this->todoRepository->expects($this->once())
            ->method('save');

        $command = new UpdateTodoCommand($id->value(), $newTitle, $newDescription);
        $this->commandHandler->__invoke($command);

        $this->assertEquals($newTitle, $todo->title()->value());
        $this->assertEquals($newDescription, $todo->description()->value());
    }
}
