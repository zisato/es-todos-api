<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

class IntegerWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/"\$\$integer\$\$"/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(function () use ($matches) {
            return '\d*?';
        });
    }
}
