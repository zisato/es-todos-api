<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\ReadModel;

use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\User\ReadModel\UserProjectionModel
 */
class UserProjectionModelTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $identification = Identification::fromValue('identification');
        $name = Name::fromValue('name');

        $projectionModel = UserProjectionModel::create($aggregateId, $identification, $name);
        
        $this->assertEquals($aggregateId->value(), $projectionModel->id());
        $this->assertEquals($identification->value(), $projectionModel->identification());
        $this->assertEquals($name->value(), $projectionModel->name());
    }

    public function testChangeName(): void
    {
        $projectionModel = UserProjectionModel::create(
            UUID::generate(),
            Identification::fromValue('identification'),
            Name::fromValue('name')
        );

        $projectionModel->changeName(Name::fromValue('new name'));
        
        $expectedNewName = 'new name';
        $this->assertEquals($expectedNewName, $projectionModel->name());
    }
}
