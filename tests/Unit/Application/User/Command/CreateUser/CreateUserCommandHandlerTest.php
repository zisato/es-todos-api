<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\CreateUser;

use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommandHandler;
use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use EsTodosApi\Domain\User\WriteModel\Repository\UserRepository;
use EsTodosApi\Domain\User\WriteModel\Service\UserIdentificationService;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Exception\AggregateRootNotFoundException;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

class CreateUserCommandHandlerTest extends TestCase
{
    /** @var UserIdentificationService|MockObject $userIdentificationService */
    private $userIdentificationService;
    /** @var UserRepository|MockObject $userRepository */
    private $userRepository;
    private CreateUserCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->userIdentificationService = $this->createMock(UserIdentificationService::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->commandHandler = new CreateUserCommandHandler($this->userIdentificationService, $this->userRepository);
    }

    public function testShouldCallUserRepositoryGetWithArguments(): void
    {
        $id = UUID::generate();
        $identification = 'User identification';
        $name = 'User name';

        $this->userRepository->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($id)
            )
            ->willThrowException(new AggregateRootNotFoundException());

        $command = new CreateUserCommand($id->value(), $identification, $name);

        $this->commandHandler->__invoke($command);
    }

    public function testShouldCallUserServiceExistsIdentificationWithArguments(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = 'User name';

        $this->userRepository->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($id)
            )
            ->willThrowException(new AggregateRootNotFoundException());

        $this->userIdentificationService->expects($this->once())
            ->method('existsIdentification')
            ->with(
                $this->equalTo($identification)
            )
            ->willReturn(false);

        $command = new CreateUserCommand($id->value(), $identification->value(), $name);

        $this->commandHandler->__invoke($command);
    }

    public function testShouldThrowInvalidArgumentExceptionWhenExistingUserIdentification(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = 'User name';

        $this->userRepository->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($id)
            )
            ->willThrowException(new AggregateRootNotFoundException());

        $this->userIdentificationService->expects($this->once())
            ->method('existsIdentification')
            ->with(
                $this->equalTo($identification)
            )
            ->willReturn(true);

        $command = new CreateUserCommand($id->value(), $identification->value(), $name);

        $this->commandHandler->__invoke($command);
    }
}
