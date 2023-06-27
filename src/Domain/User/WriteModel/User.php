<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel;

use EsTodosApi\Domain\User\WriteModel\Event\UserCreated;
use EsTodosApi\Domain\User\WriteModel\Event\UserDeleted;
use EsTodosApi\Domain\User\WriteModel\Event\UserNameChanged;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use Zisato\EventSourcing\Aggregate\AbstractAggregateRoot;
use Zisato\EventSourcing\Aggregate\AggregateRootDeletableInterface;
use Zisato\EventSourcing\Identity\IdentityInterface;

class User extends AbstractAggregateRoot implements AggregateRootDeletableInterface
{
    private Identification $identification;

    private Name $name;

    private bool $isDeleted;

    public static function create(
        IdentityInterface $aggregateId,
        Identification $identification,
        Name $name
    ): self {
        $instance = new self($aggregateId);

        $instance->recordThat(UserCreated::create($aggregateId, $identification, $name));

        return $instance;
    }

    public function identification(): Identification
    {
        return $this->identification;
    }

    public function name(): ?Name
    {
        return $this->name;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function delete(): void
    {
        if ($this->isDeleted() === false) {
            $this->recordThat(UserDeleted::create($this->id()));
        }
    }

    public function changeName(Name $newName): void
    {
        if ($this->name()->equals($newName) === false) {
            $this->recordThat(
                UserNameChanged::create($this->id(), $this->name(), $newName)
            );
        }
    }

    protected function applyUserCreated(UserCreated $event): void
    {
        $this->identification = $event->identification();
        $this->name = $event->name();
        $this->isDeleted = false;
    }

    protected function applyUserDeleted(UserDeleted $event): void
    {
        $this->isDeleted = true;
    }

    protected function applyUserNameChanged(UserNameChanged $event): void
    {
        $this->name = $event->name();
    }
}
