<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Identity\IdentityInterface;

class TodoDescriptionChanged extends AbstractEvent
{
    private const DEFAULT_VERSION = 1;

    private const INDEX_NEW_VALUE = 'new_description';

    private const INDEX_PREVIOUS_VALUE = 'previous_description';

    public static function defaultVersion(): int
    {
        return static::DEFAULT_VERSION;
    }

    public static function create(IdentityInterface $aggregateId, ?Description $previousDescription, ?Description $newDescription): self
    {
        /** @var TodoDescriptionChanged $event */
        $event = self::occur(
            $aggregateId->value(),
            [
                self::INDEX_PREVIOUS_VALUE => $previousDescription
                    ? $previousDescription->value()
                    : null,
                self::INDEX_NEW_VALUE => $newDescription
                    ? $newDescription->value()
                    : null,
            ]
        );

        return $event;
    }

    public function description(): ?Description
    {
        return $this->payload()[self::INDEX_NEW_VALUE]
            ? Description::fromValue($this->payload()[self::INDEX_NEW_VALUE])
            : null;
    }
}
