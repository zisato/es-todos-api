<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\Event\Upcaster;

use DateTimeImmutable;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDeleted;
use EsTodosApi\Domain\Todo\WriteModel\Event\Upcaster\TodoCreatedV2Upcaster;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Event\EventInterface;
use Zisato\EventSourcing\Aggregate\Event\Upcast\UpcasterInterface;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\Event\Upcaster\TodoCreatedV2Upcaster
 */
final class TodoCreatedV2UpcasterTest extends TestCase
{
    private readonly UpcasterInterface $upcaster;

    protected function setUp(): void
    {
        $this->upcaster = new TodoCreatedV2Upcaster();        
    }

    /**
     * @dataProvider getCanUpcastData
     */
    public function testCanUpcast(EventInterface $event, bool $expectedResult): void
    {
        $result = $this->upcaster->canUpcast($event);

        $this->assertEquals($expectedResult, $result);
    }

    public function testUpcast(): void
    {
        $event = TodoCreated::reconstitute(
            UUID::generate()->value(),
            1,
            new DateTimeImmutable(),
            [],
            1,
            []
        );
        $result = $this->upcaster->upcast($event);

        $expectedPayload = [
            'description' => null,
        ];
        $this->assertEquals($expectedPayload, $result->payload());
    }

    public static function getCanUpcastData(): array
    {
        return [
            'not event instance' => [
                TodoDeleted::create(UUID::generate()),
                false,
            ],
            'not version from' => [
                TodoCreated::reconstitute(
                    UUID::generate()->value(),
                    1,
                    new DateTimeImmutable(),
                    [],
                    2,
                    []
                ),
                false,
            ],
            'right version from' => [
                TodoCreated::reconstitute(
                    UUID::generate()->value(),
                    1,
                    new DateTimeImmutable(),
                    [],
                    1,
                    []
                ),
                true,
            ],
        ];
    }
}
