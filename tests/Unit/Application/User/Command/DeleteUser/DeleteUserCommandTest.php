<?php

namespace EsTodosApi\Tests\Unit\Application\User\Command\DeleteUser;

use EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommand;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Command\DeleteUser\DeleteUserCommand
 */
final class DeleteUserCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate()->value();

        $command = new DeleteUserCommand($id);
        
        $this->assertEquals($id, $command->id());
    }
}
