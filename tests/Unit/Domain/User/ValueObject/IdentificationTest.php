<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\ValueObject;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Identification;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Domain\User\WriteModel\ValueObject\Identification
 */
class IdentificationTest extends TestCase
{
    /**
     * @dataProvider getInvalidData
     */
    public function testItShouldThrowInvalidArgumentExceptionWhenInvalidValue(string $value)
    {
        $this->expectException(InvalidArgumentException::class);

        Identification::fromValue($value);
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(string $identificationValue, string $anotherIdentificationValue, bool $expectedResult)
    {
        $identification = Identification::fromValue($identificationValue);
        $anotherIdentification = Identification::fromValue($anotherIdentificationValue);

        $this->assertEquals($expectedResult, $identification->equals($anotherIdentification));
    }

    public static function getInvalidData(): array
    {
        return [
            [''],
            ['0123'],
            ['     '],
            [
                str_repeat('0123456789', 25) . '0123456',
            ],
        ];
    }

    public static function getEqualsData(): array
    {
        return [
            [
                'User identification',
                'User identification',
                true
            ],
            [
                'User identification',
                'Another User identification',
                false
            ],
        ];
    }
}
