<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\ReadModel\Repository;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use Zisato\Projection\Criteria\Condition;
use Zisato\Projection\Criteria\Criteria;
use Zisato\Projection\Criteria\CriteriaItem;
use Zisato\Projection\Infrastructure\MongoDB\Repository\MongoDBRepository;
use Zisato\Projection\ValueObject\ProjectionModelCollection;

class MongoDbUserProjectionRepository extends MongoDBRepository implements UserProjectionRepository
{
    private const DATABASE_NAME = 'es_todos_api';
    
    private const COLLECTION_NAME = 'users';

    public static function getProjectionModelName(): string
    {
        return UserProjectionModel::class;
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

    public function findByIdentification(string $identification): ?UserProjectionModel
    {
        $collection = $this->findBy(
            new Criteria(new CriteriaItem('identification', $identification, Condition::like())),
            0,
            1
        );

        if ($collection->total() === 0) {
            return null;
        }

        return iterator_to_array($collection->data())[0];
    }

    public function get(string $id): UserProjectionModel
    {
        /** @var UserProjectionModel $result */
        $result = parent::get($id);

        return $result;
    }
}
