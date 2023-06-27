<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\ReadModel\Repository;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use Zisato\Projection\Infrastructure\MongoDB\Repository\MongoDBRepository;

class MongoDbTodoProjectionRepository extends MongoDBRepository implements TodoProjectionRepository
{
    private const DATABASE_NAME = 'es_todos_api';
    
    private const COLLECTION_NAME = 'todos';

    public static function getProjectionModelName(): string
    {
        return TodoProjectionModel::class;
    }

    public function getDatabaseName(): string
    {
        return self::DATABASE_NAME;
    }

    public function getCollectionName(): string
    {
        return self::COLLECTION_NAME;
    }

    public function get(string $id): TodoProjectionModel
    {
        /** @var TodoProjectionModel $result */
        $result = parent::get($id);

        return $result;
    }
}
