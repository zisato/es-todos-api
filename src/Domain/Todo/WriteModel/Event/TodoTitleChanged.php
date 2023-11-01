<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Identity\IdentityInterface;

final class TodoTitleChanged extends AbstractEvent
{
    private const DEFAULT_VERSION = 1;

    private const INDEX_NEW_VALUE = 'new_title';

    private const INDEX_PREVIOUS_VALUE = 'previous_title';

    public static function defaultVersion(): int
    {
        return self::DEFAULT_VERSION;
    }

    public static function create(IdentityInterface $aggregateId, Title $previousTitle, Title $newTitle): self
    {
        /** @var TodoTitleChanged $event */
        $event = self::occur(
            $aggregateId->value(),
            [
                self::INDEX_PREVIOUS_VALUE => $previousTitle->value(),
                self::INDEX_NEW_VALUE => $newTitle->value(),
            ]
        );

        return $event;
    }

    public function title(): Title
    {
        return Title::fromValue($this->payload()[self::INDEX_NEW_VALUE]);
    }
}
