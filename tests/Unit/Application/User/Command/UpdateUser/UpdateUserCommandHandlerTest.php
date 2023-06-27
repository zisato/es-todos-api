<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\UpdateUser;

use EsTodosApi\Application\User\Command\UpdateUser\UpdateUserCommand;
use EsTodosApi\Application\User\Command\UpdateUser\UpdateUserCommandHandler;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class UpdateUserCommandHandlerTest extends TestCase
{
    /** @var UserRepository|MockObject $userRepository */
    private $userRepository;
    private UpdateUserCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->commandHandler = new UpdateUserCommandHandler($this->userRepository);
    }

    public function testShouldUpdateTodo(): void
    {
        $id = UUID::generate();
        $identification = 'User identification';
        $name = 'User name';
        $user = User::create($id, Identification::fromValue($identification), Name::fromValue($name));
        $newName = 'New User name';
        $this->userRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($id))
            ->willReturn($user);

        $this->userRepository->expects($this->once())
            ->method('save');

        $command = new UpdateUserCommand($id->value(), $newName);
        $this->commandHandler->__invoke($command);

        $this->assertEquals($newName, $user->name()->value());
    }
}
