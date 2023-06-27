<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\DeleteTodo;

use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommand;
use EsTodosApi\Application\Todo\Command\DeleteTodo\DeleteTodoCommandHandler;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class DeleteTodoCommandHandlerTest extends TestCase
{
    /** @var TodoRepository|MockObject $todoRepository */
    private $todoRepository;
    private DeleteTodoCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->todoRepository = $this->createMock(TodoRepository::class);
        $this->commandHandler = new DeleteTodoCommandHandler($this->todoRepository);
    }

    public function testShouldChangeDelete(): void
    {
        $id = UUID::generate();
        $userId = UUID::generate();
        $todo = Todo::create($id, $userId, Title::fromValue('Todo title'), Description::fromValue('Todo description'));
        $this->todoRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($id))
            ->willReturn($todo);
        $expectedIsDeleted = true;

        $command = new DeleteTodoCommand($id->value());
        $this->commandHandler->__invoke($command);
        
        $this->assertEquals($expectedIsDeleted, $todo->isDeleted());
    }
}
