<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\CreateUser;

use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommandHandler;
use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\User;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Command\CreateUser\CreateUserCommandHandler
 */
class CreateUserCommandHandlerTest extends TestCase
{
    private UserRepository|MockObject $userRepository;
    private CreateUserCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->commandHandler = new CreateUserCommandHandler($this->userRepository);
    }

    public function testShouldSaveUser(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = 'User name';

        $this->userRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (User $user) use ($id) {
                $this->assertEquals($id, $user->id());

                return true;
            });

        $command = new CreateUserCommand($id->value(), $identification->value(), $name);
        $this->commandHandler->__invoke($command);
    }
}
