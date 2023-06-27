<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\User\ReadModel\Repository;

use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use Zisato\Projection\Infrastructure\MongoDB\Repository\MongoDBRepository;

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

    public function get(string $id): UserProjectionModel
    {
        /** @var UserProjectionModel $result */
        $result = parent::get($id);

        return $result;
    }
}
