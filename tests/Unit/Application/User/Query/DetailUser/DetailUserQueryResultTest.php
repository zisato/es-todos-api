<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\DetailUser;

use EsTodosApi\Application\User\Query\DetailUser\DetailUserQueryResult;
use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Query\DetailUser\DetailUserQueryResult
 */
final class DetailUserQueryResultTest extends TestCase
{
    public function testCreate(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = Name::fromValue('User name');
        $projectionModel = UserProjectionModel::create($id, $identification, $name);
        $transformer = new UserJsonApiTransformer();

        $queryResult = DetailUserQueryResult::create($projectionModel, $transformer);

        $expectedResult = [
            'id' => $id->value(),
            'attributes' => [
                'identification' => 'User identification',
                'name' => 'User name',
            ],
        ];
        $this->assertEquals($expectedResult, $queryResult->data());
    }
}
