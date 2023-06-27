<?php

namespace EsTodosApi\Application\Todo\Transformer;

use Zisato\Projection\Transformer\ProjectionModelTransformer;
use Zisato\Projection\ValueObject\ProjectionModel;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;

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
                ]
            ]
        ];
    }
}
