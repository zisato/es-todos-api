<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\ReadModel;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use Zisato\EventSourcing\Identity\IdentityInterface;
use Zisato\Projection\ValueObject\ProjectionModel;

class UserProjectionModel extends ProjectionModel
{
    public static function create(
        IdentityInterface $id,
        Identification $identification,
        Name $name
    ): self {
        /** @var UserProjectionModel $result */
        $result = static::fromData([
            'id' => $id->value(),
            'identification' => $identification->value(),
            'name' => $name->value(),
        ]);

        return $result;
    }

    public function id(): string
    {
        return $this->data()['id'];
    }

    public function identification(): string
    {
        return $this->data()['identification'];
    }

    public function name(): string
    {
        return $this->data()['name'];
    }

    public function changeName(Name $newName): void
    {
        $newData = $this->data();

        $newData['name'] = $newName->value();

        $this->changeData($newData);
    }
}
