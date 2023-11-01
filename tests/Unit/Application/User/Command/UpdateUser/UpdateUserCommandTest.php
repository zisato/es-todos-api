<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\UpdateUser;

use EsTodosApi\Application\User\Command\UpdateUser\UpdateUserCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Command\UpdateUser\UpdateUserCommand
 */
final class UpdateUserCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();
        $newName = 'New User name';

        $command = new UpdateUserCommand($id, $newName);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($newName, $command->name());
    }
}
