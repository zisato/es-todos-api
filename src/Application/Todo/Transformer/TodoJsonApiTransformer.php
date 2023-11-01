<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Transformer;

use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use Zisato\Projection\Transformer\ProjectionModelTransformer;
use Zisato\Projection\ValueObject\ProjectionModel;

final class TodoJsonApiTransformer implements ProjectionModelTransformer
{
    /**
     * @param TodoProjectionModel $projectionModel
     *
     * @return array<string, mixed>
     */
    public function transform(ProjectionModel $projectionModel): array
    {
        return [
            'id' => $projectionModel->id(),
            'attributes' => [
                'title' => $projectionModel->title(),
                'description' => $projectionModel->description(),
            ],
            'relationships' => [
                'user' => [
                    'id' => $projectionModel->userId(),
                ],
            ],
        ];
    }
}
