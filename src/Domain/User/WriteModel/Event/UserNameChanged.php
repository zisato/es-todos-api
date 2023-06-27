<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Identity\IdentityInterface;

class UserNameChanged extends AbstractEvent
{
    private const DEFAULT_VERSION = 1;

    private const INDEX_NEW_VALUE = 'new_name';

    private const INDEX_PREVIOUS_VALUE = 'previous_name';

    public static function defaultVersion(): int
    {
        return static::DEFAULT_VERSION;
    }

    public static function create(IdentityInterface $aggregateId, Name $previousName, Name $newName): self
    {
        /** @var UserNameChanged $event */
        $event = self::occur(
            $aggregateId->value(),
            [
                self::INDEX_PREVIOUS_VALUE => $previousName->value(),
                self::INDEX_NEW_VALUE => $newName->value()
            ]
        );

        return $event;
    }

    public function name(): Name
    {
        return Name::fromValue($this->payload()[self::INDEX_NEW_VALUE]);
    }
}
