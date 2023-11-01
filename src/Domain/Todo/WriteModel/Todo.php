<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel;

use EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDeleted;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoDescriptionChanged;
use EsTodosApi\Domain\Todo\WriteModel\Event\TodoTitleChanged;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use Zisato\EventSourcing\Aggregate\AbstractAggregateRoot;
use Zisato\EventSourcing\Aggregate\AggregateRootDeletableInterface;
use Zisato\EventSourcing\Identity\IdentityInterface;

final class Todo extends AbstractAggregateRoot implements AggregateRootDeletableInterface
{
    private IdentityInterface $userId;

    private Title $title;

    private ?Description $description;

    private bool $isDeleted;

    public static function create(
        IdentityInterface $aggregateId,
        IdentityInterface $userId,
        Title $title,
        ?Description $description
    ): self {
        $instance = new self($aggregateId);

        $instance->recordThat(TodoCreated::create($aggregateId, $userId, $title, $description));

        return $instance;
    }

    public function userId(): IdentityInterface
    {
        return $this->userId;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function description(): ?Description
    {
        return $this->description;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function delete(): void
    {
        if (! $this->isDeleted) {
            $this->recordThat(TodoDeleted::create($this->id()));
        }
    }

    public function changeTitle(Title $newTitle): void
    {
        if (! $this->title->equals($newTitle)) {
            $this->recordThat(TodoTitleChanged::create($this->id(), $this->title, $newTitle));
        }
    }

    public function changeDescription(?Description $newDescription): void
    {
        $previousDescriptionValue = $this->description instanceof Description ? $this->description->value() : null;
        $newDescriptionValue = $newDescription instanceof Description ? $newDescription->value() : null;

        if ($previousDescriptionValue !== $newDescriptionValue) {
            $this->recordThat(TodoDescriptionChanged::create($this->id(), $this->description, $newDescription));
        }
    }

    protected function applyTodoCreated(TodoCreated $event): void
    {
        $this->userId = $event->userId();
        $this->title = $event->title();
        $this->description = $event->description();
        $this->isDeleted = false;
    }

    protected function applyTodoDeleted(TodoDeleted $event): void
    {
        $this->isDeleted = true;
    }

    protected function applyTodoTitleChanged(TodoTitleChanged $event): void
    {
        $this->title = $event->title();
    }

    protected function applyTodoDescriptionChanged(TodoDescriptionChanged $event): void
    {
        $this->description = $event->description();
    }
}
