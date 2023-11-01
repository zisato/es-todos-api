<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\User\WriteModel\ValueObject;

use EsTodosApi\Domain\User\WriteModel\ValueObject\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Domain\User\WriteModel\ValueObject\Name
 */
class NameTest extends TestCase
{
    /**
     * @dataProvider getInvalidData
     */
    public function testItShouldThrowInvalidArgumentExceptionWhenInvalidValue(string $value)
    {
        $this->expectException(InvalidArgumentException::class);

        Name::fromValue($value);
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(string $nameValue, string $anotherNameValue, bool $expectedResult)
    {
        $name = Name::fromValue($nameValue);
        $anotherName = Name::fromValue($anotherNameValue);

        $this->assertEquals($expectedResult, $name->equals($anotherName));
    }

    public static function getInvalidData(): array
    {
        return [
            [''],
            [' '],
            [
                str_repeat('0123456789', 25) . '0123456',
            ],
        ];
    }

    public static function getEqualsData(): array
    {
        return [
            [
                'User name',
                'User name',
                true
            ],
            [
                'User name',
                'Another User name',
                false
            ],
        ];
    }
}
