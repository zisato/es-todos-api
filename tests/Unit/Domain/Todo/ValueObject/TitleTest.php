<?php

declare(strict_types=1);

namespace EsTodosApi\Tests\Unit\Domain\Todo\WriteModel\ValueObject;

use EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EsTodosApi\Domain\Todo\WriteModel\ValueObject\Title
 */
class TitleTest extends TestCase
{
    /**
     * @dataProvider getInvalidData
     */
    public function testItShouldThrowInvalidArgumentExceptionWhenInvalidValue(string $value)
    {
        $this->expectException(InvalidArgumentException::class);

        Title::fromValue($value);
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(string $titleValue, string $anotherTitleValue, bool $expectedResult)
    {
        $title = Title::fromValue($titleValue);
        $anotherTitle = Title::fromValue($anotherTitleValue);

        $this->assertEquals($expectedResult, $title->equals($anotherTitle));
    }

    public static function getInvalidData(): array
    {
        return [
            [''],
            [
                str_repeat('0123456789', 25) . '0123456',
            ],
        ];
    }

    public static function getEqualsData(): array
    {
        return [
            [
                'Todo title',
                'Todo title',
                true
            ],
            [
                'Todo title',
                'Another Todo title',
                false
            ],
        ];
    }
}
