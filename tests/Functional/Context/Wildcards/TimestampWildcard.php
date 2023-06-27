<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

class TimestampWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/\$\$timestamp:([^\$\$]+)\$\$/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(function () use ($matches) {
            return (new \DateTime($matches[1]))->getTimestamp();
        });
    }
}
