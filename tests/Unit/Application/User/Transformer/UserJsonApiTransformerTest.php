<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Application\User\Transformer;

use EsTodosApi\Application\User\Transformer\UserJsonApiTransformer;
use EsTodosApi\Domain\User\ReadModel\UserProjectionModel;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Identity\UUID;

/**
 * @covers \EsTodosApi\Application\User\Transformer\UserJsonApiTransformer
 */
final class UserJsonApiTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $id = UUID::generate();
        $identification = Identification::fromValue('identification');
        $name = Name::fromValue('name');
        $todoProjectionModel = UserProjectionModel::create($id, $identification, $name);

        $transformer = new UserJsonApiTransformer();
        $result = $transformer->transform($todoProjectionModel);

        $expectedResult = [
            'id' => $id->value(),
            'attributes' => [
                'identification' => 'identification',
                'name' => 'name',
            ],
        ];
        $this->assertEquals($expectedResult, $result);
    }
}
