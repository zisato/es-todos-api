<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\Event;

use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Identity\IdentityInterface;

class UserDeleted extends AbstractEvent
{
    private const DEFAULT_VERSION = 1;

    public static function defaultVersion(): int
    {
        return static::DEFAULT_VERSION;
    }

    public static function create(IdentityInterface $aggregateId): self
    {
        /** @var UserDeleted $event */
        $event = self::occur($aggregateId->value());

        return $event;
    }
}
