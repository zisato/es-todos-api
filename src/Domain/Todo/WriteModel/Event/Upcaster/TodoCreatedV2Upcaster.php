<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Event\Upcaster;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated;
use Zisato\EventSourcing\Aggregate\Event\EventInterface;
use Zisato\EventSourcing\Aggregate\Event\Upcast\UpcasterInterface;

final class TodoCreatedV2Upcaster implements UpcasterInterface
{
    private const INDEX_DESCRIPTION = 'description';

    private const VERSION_FROM = 1;

    private const VERSION_TO = 2;

    public function canUpcast(EventInterface $event): bool
    {
        return $event->version() === self::VERSION_FROM;
    }

    public function upcast(EventInterface $event): TodoCreated
    {
        $newPayload = $event->payload();
        $newPayload[self::INDEX_DESCRIPTION] = null;

        /** @var TodoCreated $upcastedEvent */
        $upcastedEvent = TodoCreated::reconstitute(
            $event->aggregateId(),
            $event->aggregateVersion(),
            $event->createdAt(),
            $newPayload,
            self::VERSION_TO,
            $event->metadata()
        );

        return $upcastedEvent;
    }
}
