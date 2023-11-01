<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\ValueObject;

use InvalidArgumentException;

class Title
{
    private const LENGTH_MAX = 255;

    private const LENGTH_MIN = 1;

    private string $value;

    protected function __construct(string $value)
    {
        $this->checkValidValue($value);

        $this->value = $value;
    }

    public static function fromValue(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $title): bool
    {
        return $this->value() === $title->value();
    }

    private function checkValidValue(string $value): void
    {
        $length = \strlen($value);

        if ($length < self::LENGTH_MIN) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Title min length. Min length allowed: %d',
                self::LENGTH_MIN
            ));
        }

        if ($length > self::LENGTH_MAX) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Title max length. Max length allowed: %d',
                self::LENGTH_MAX
            ));
        }
    }
}
