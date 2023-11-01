<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\Event;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use Zisato\EventSourcing\Aggregate\Event\AbstractEvent;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\PrivateDataPayloadInterface;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\ValueObject\PayloadKey;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\ValueObject\PayloadKeyCollection;
use Zisato\EventSourcing\Identity\IdentityInterface;

final class UserCreated extends AbstractEvent implements PrivateDataPayloadInterface
{
    private const DEFAULT_VERSION = 1;

    private const INDEX_IDENTIFICATION = 'identification';

    private const INDEX_NAME = 'name';

    public static function defaultVersion(): int
    {
        return self::DEFAULT_VERSION;
    }

    public static function create(
        IdentityInterface $aggregateId,
        Identification $identification,
        Name $name
    ): self {
        /** @var UserCreated $event */
        $event = self::occur(
            $aggregateId->value(),
            [
                self::INDEX_IDENTIFICATION => $identification->value(),
                self::INDEX_NAME => $name->value(),
            ]
        );

        return $event;
    }

    public function privateDataPayloadKeys(): PayloadKeyCollection
    {
        return PayloadKeyCollection::create(PayloadKey::create(self::INDEX_IDENTIFICATION));
    }

    public function identification(): Identification
    {
        return Identification::fromValue($this->payload()[self::INDEX_IDENTIFICATION]);
    }

    public function name(): Name
    {
        return Name::fromValue($this->payload()[self::INDEX_NAME]);
    }
}
