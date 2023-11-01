<?php

declare(strict_types=1);

namespace EsTodosApi\Domain\User\WriteModel\ValueObject;

use InvalidArgumentException;

final class Identification
{
    private const LENGTH_MAX = 255;

    private const LENGTH_MIN = 5;

    private readonly string $value;

    private function __construct(string $value)
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
        return $this->value === $title->value();
    }

    private function checkValidValue(string $value): void
    {
        $length = \strlen(trim($value));

        if ($length < self::LENGTH_MIN) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Identification min length. Min length allowed: %d',
                self::LENGTH_MIN
            ));
        }

        if ($length > self::LENGTH_MAX) {
            throw new InvalidArgumentException(\sprintf(
                'Invalid Identification max length. Max length allowed: %d',
                self::LENGTH_MAX
            ));
        }
    }
}
