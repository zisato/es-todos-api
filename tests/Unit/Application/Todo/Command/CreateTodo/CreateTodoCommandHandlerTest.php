<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\CreateTodo;

use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommandHandler;
use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class CreateTodoCommandHandlerTest extends TestCase
{
    /** @var TodoRepository|MockObject $todoRepository */
    private $todoRepository;
    /** @var UserRepository|MockObject $userRepository */
    private $userRepository;
    private CreateTodoCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->todoRepository = $this->createMock(TodoRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->commandHandler = new CreateTodoCommandHandler($this->todoRepository, $this->userRepository);
    }

    public function testShouldCreateTodo(): void
    {
        $id = UUID::generate();
        $userId = '9f303847-2bcb-4d24-ad34-450187474041';
        $title = 'Todo title';
        $description = 'Todo description';

        $this->todoRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Todo $todo) use ($id) {
                $this->assertEquals($id, $todo->id());

                return true;
            });

        $command = new CreateTodoCommand($id->value(), $userId, $title, $description);

        $this->commandHandler->__invoke($command);
    }
}
