<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Event;

use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Identity\IdentityInterface;

class TodoDeleted extends AbstractEvent
{
    private const DEFAULT_VERSION = 1;

    public static function defaultVersion(): int
    {
        return self::DEFAULT_VERSION;
    }

    public static function create(IdentityInterface $aggregateId): self
    {
        /** @var TodoDeleted $event */
        $event = self::occur($aggregateId->value());

        return $event;
    }
}
