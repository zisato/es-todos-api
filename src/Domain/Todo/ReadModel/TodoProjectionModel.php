<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\ReadModel;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use Zisato\EventSourcing\Identity\IdentityInterface;
use Zisato\Projection\ValueObject\ProjectionModel;

final class TodoProjectionModel extends ProjectionModel
{
    public static function create(
        IdentityInterface $id,
        IdentityInterface $userId,
        Title $title,
        ?Description $description
    ): self {
        /** @var TodoProjectionModel $result */
        $result = static::fromData([
            'id' => $id->value(),
            'userId' => $userId->value(),
            'title' => $title->value(),
            'description' => $description instanceof \EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description
                ? $description->value()
                : null,
        ]);

        return $result;
    }

    public function id(): string
    {
        return $this->data()['id'];
    }

    public function userId(): string
    {
        return $this->data()['userId'];
    }

    public function title(): string
    {
        return $this->data()['title'];
    }

    public function description(): ?string
    {
        return $this->data()['description'];
    }

    public function changeTitle(Title $newTitle): void
    {
        $newData = $this->data();

        $newData['title'] = $newTitle->value();

        $this->changeData($newData);
    }

    public function changeDescription(?Description $newDescription): void
    {
        $newData = $this->data();

        $description = $newDescription instanceof \EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description ? $newDescription->value() : null;
        $newData['description'] = $description;

        $this->changeData($newData);
    }
}
