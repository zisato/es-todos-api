<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Transformer;

use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use Zisato\Projection\Transformer\ProjectionModelTransformer;
use Zisato\Projection\ValueObject\ProjectionModel;

final class UserJsonApiTransformer implements ProjectionModelTransformer
{
    /**
     * @param UserProjectionModel $projectionModel
     *
     * @return array<string, mixed>
     */
    public function transform(ProjectionModel $projectionModel): array
    {
        return [
            'id' => $projectionModel->id(),
            'attributes' => [
                'identification' => $projectionModel->identification(),
                'name' => $projectionModel->name(),
            ],
        ];
    }
}
