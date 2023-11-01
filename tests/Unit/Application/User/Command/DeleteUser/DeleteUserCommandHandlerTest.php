<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\DeleteUser;

use EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommand;
use EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommandHandler;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommandHandler
 */
final class DeleteUserCommandHandlerTest extends TestCase
{
    private UserRepository|MockObject $userRepository;

    private DeleteUserCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->commandHandler = new DeleteUserCommandHandler($this->userRepository);
    }

    public function testShouldChangeDelete(): void
    {
        $id = UUID::generate();
        $identification = 'User identification';
        $name = 'User name';
        $user = User::create(UUID::generate(), Identification::fromValue($identification), Name::fromValue($name));
        $this->userRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($id))
            ->willReturn($user);
        $expectedIsDeleted = true;

        $command = new DeleteUserCommand($id->value());
        $this->commandHandler->__invoke($command);

        $this->assertEquals($expectedIsDeleted, $user->isDeleted());
    }
}
