<?php

declare(strict_types=1);

namespace EsTodosApi\Application\User\Query\DetailUser;

use Zisato\CQRS\ReadModel\ValueObject\QueryResult;
use Zisato\Projection\Transformer\ProjectionModelTransformer;
use Zisato\Projection\ValueObject\ProjectionModel;

final class DetailUserQueryResult implements QueryResult
{
    /**
     * @param array<int, mixed> $data
     */
    private function __construct(private readonly array $data) {}

    public static function create(
        ProjectionModel $projectionModel,
        ProjectionModelTransformer $transformer
    ): DetailUserQueryResult {
        /** @var array<int, mixed> $data */
        $data = $transformer->transform($projectionModel);

        return new DetailUserQueryResult($data);
    }

    public function data(): array
    {
        return $this->data;
    }
}
