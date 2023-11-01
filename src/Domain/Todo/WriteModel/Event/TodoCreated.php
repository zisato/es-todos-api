<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\Event;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Aggregate\Identity\UUID;
use Zisato\EventSourcing\Identity\IdentityInterface;

class TodoCreated extends AbstractEvent
{
    private const DEFAULT_VERSION = 2;

    private const INDEX_TITLE = 'title';

    private const INDEX_DESCRIPTION = 'description';

    private const INDEX_USER_ID = 'user_id';

    public static function defaultVersion(): int
    {
        return self::DEFAULT_VERSION;
    }

    public static function create(
        IdentityInterface $aggregateId,
        IdentityInterface $userId,
        Title $title,
        ?Description $description
    ): self {
        /** @var TodoCreated $event */
        $event = self::occur(
            $aggregateId->value(),
            [
                self::INDEX_USER_ID => $userId->value(),
                self::INDEX_TITLE => $title->value(),
                self::INDEX_DESCRIPTION => $description
                    ? $description->value()
                    : null,
            ]
        );

        return $event;
    }

    public function userId(): IdentityInterface
    {
        return UUID::fromString($this->payload()[self::INDEX_USER_ID]);
    }

    public function title(): Title
    {
        return Title::fromValue($this->payload()[self::INDEX_TITLE]);
    }

    public function description(): ?Description
    {
        return $this->payload()[self::INDEX_DESCRIPTION]
            ? Description::fromValue($this->payload()[self::INDEX_DESCRIPTION])
            : null;
    }
}
