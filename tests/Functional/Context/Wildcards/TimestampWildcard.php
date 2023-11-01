<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

final class TimestampWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/\$\$timestamp:([^\$\$]+)\$\$/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(static function () use ($matches) : int {
            return (new \DateTime($matches[1]))->getTimestamp();
        });
    }
}
