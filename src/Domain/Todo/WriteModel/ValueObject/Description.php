<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\Todo\WriteModel\ValueObject;

use InvalidArgumentException;

class Description
{
    private const LENGTH_MAX = 1000;

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

        if ($length < static::LENGTH_MIN) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Description min length. Min length allowed: %d',
                static::LENGTH_MIN
            ));
        }

        if ($length > static::LENGTH_MAX) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Description max length. Max length allowed: %d',
                static::LENGTH_MAX
            ));
        }
    }
}
