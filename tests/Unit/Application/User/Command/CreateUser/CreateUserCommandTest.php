<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\CreateUser;

use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand
 */
final class CreateUserCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();
        $identification = 'User identification';
        $name = 'User name';

        $command = new CreateUserCommand($id, $identification, $name);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($identification, $command->identification());
        $this->assertEquals($name, $command->name());
    }
}
