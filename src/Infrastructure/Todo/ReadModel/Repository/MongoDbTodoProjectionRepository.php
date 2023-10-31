<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Todo\ReadModel\Repository;

use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use EsTodosApi\Domain\Todo\ReadModel\TodoProjectionModel;
use Zisato\Projection\Criteria\Condition;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\Criteria\CriteriaItem;
use Zisato\Projection\Infrastructure\MongoDB\Repository\MongoDBRepository;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

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

    public function findAll(int $offset, int $limit): ProjectionModelCollection
    {
        return $this->findBy(null, $offset, $limit);
    }

    public function findByUserId(string $userId): ProjectionModelCollection
    {
        return $this->findBy(new Criteria(new CriteriaItem('userId', $userId, Condition::eq())));
    }

    public function get(string $id): TodoProjectionModel
    {
        /** @var TodoProjectionModel $result */
        $result = parent::get($id);

        return $result;
    }
}
