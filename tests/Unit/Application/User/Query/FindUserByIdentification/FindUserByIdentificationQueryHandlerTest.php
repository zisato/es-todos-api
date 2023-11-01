<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Query\FindUserByIdentification;

use EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQuery;
use EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQueryHandler;
use EsTodosApi\Domain\User\ReadModel\Repository\UserProjectionRepository;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Query\FindUserByIdentification\FindUserByIdentificationQueryHandler
 */
final class FindUserByIdentificationQueryHandlerTest extends TestCase
{
    private UserProjectionRepository|MockObject $userProjectionRepository;

    private FindUserByIdentificationQueryHandler $queryHandler;

    protected function setUp(): void
    {
        $this->userProjectionRepository = $this->createMock(UserProjectionRepository::class);
        $this->queryHandler = new FindUserByIdentificationQueryHandler($this->userProjectionRepository);
    }

    public function testShouldCallServiceWithArguments(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('User identification');
        $name = Name::fromValue('User name');
        $userProjection = UserProjectionModel::create($id, $identification, $name);
        $this->userProjectionRepository->expects($this->once())
            ->method('findByIdentification')
            ->with(
                $this->equalTo($identification->value()),
            )
            ->willReturn($userProjection);
        $expectedResult = [
            'id' => $id->value(),
            'attributes' => [
                'identification' => 'User identification',
                'name' => 'User name',
            ],
        ];

        $query = new FindUserByIdentificationQuery($identification->value());
        $result = $this->queryHandler->__invoke($query);

        $this->assertEquals($expectedResult, $result->data());
    }
}
