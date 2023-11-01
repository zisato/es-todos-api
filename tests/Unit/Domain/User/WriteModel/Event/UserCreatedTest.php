<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\User\WriteModel\Event\UserCreated;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\ValueObject\PayloadKey;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\User\WriteModel\Event\UserCreated
 */
final class UserCreatedTest extends TestCase
{
    public function testCreateSuccessfully(): void
    {
        $aggregateId = UUID::generate();
        $identification = Identification::fromValue('identification');
        $name = Name::fromValue('name');

        $event = UserCreated::create($aggregateId, $identification, $name);

        $expectedDefaultVersion = 1;
        $this->assertEquals($aggregateId->value(), $event->aggregateId());
        $this->assertEquals($identification, $event->identification());
        $this->assertEquals($name, $event->name());
        $this->assertEquals($expectedDefaultVersion, $event::defaultVersion());
    }

    public function testPrivateDataPayloadKeys(): void
    {
        $event = UserCreated::create(
            UUID::generate(),
            Identification::fromValue('identification'),
            Name::fromValue('name')
        );

        $expectedPrivateDataPayloadKeys = [PayloadKey::create('identification')];
        $values = iterator_to_array($event->privateDataPayloadKeys()->values());
        $this->assertEquals($expectedPrivateDataPayloadKeys, $values);
    }
}
