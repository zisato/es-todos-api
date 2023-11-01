<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\Todo\WriteModel\ValueObject;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\ValueObject\Description
 */
class DescriptionTest extends TestCase
{
    /**
     * @dataProvider getInvalidData
     */
    public function testItShouldThrowInvalidArgumentExceptionWhenInvalidValue(string $value)
    {
        $this->expectException(InvalidArgumentException::class);

        Description::fromValue($value);
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(string $descriptionValue, string $anotherDescriptionValue, bool $expectedResult)
    {
        $description = Description::fromValue($descriptionValue);
        $anotherDescription = Description::fromValue($anotherDescriptionValue);

        $this->assertEquals($expectedResult, $description->equals($anotherDescription));
    }

    public static function getInvalidData(): array
    {
        return [
            [''],
            [
                str_repeat('0123456789', 100) . '0',
            ],
        ];
    }

    public static function getEqualsData(): array
    {
        return [
            [
                'Todo description',
                'Todo description',
                true
            ],
            [
                'Todo description',
                'Another Todo description',
                false
            ],
        ];
    }
}
