<?php

namespace EsTodosApi\Tests\Unit\Application\Todo\Command\CreateTodo;

use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommandHandler;
use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand;
use EsTodosApi\Domain\Todo\WriteModel\Repository\TodoRepository;
use EsTodosApi\Domain\Todo\WriteModel\Todo;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommandHandler
 */
final class CreateTodoCommandHandlerTest extends TestCase
{
    private TodoRepository|MockObject $todoRepository;

    private UserRepository|MockObject $userRepository;

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
        $user = User::create(UUID::fromString($userId), Identification::fromValue('identification'), Name::fromValue('name'));

        $this->userRepository->expects($this->once())
            ->method('get')
            ->willReturn($user);

        $this->todoRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Todo $todo) use ($id): bool {
                $this->assertEquals($id, $todo->id());

                return true;
            });

        $command = new CreateTodoCommand($id->value(), $userId, $title, $description);

        $this->commandHandler->__invoke($command);
    }
}
