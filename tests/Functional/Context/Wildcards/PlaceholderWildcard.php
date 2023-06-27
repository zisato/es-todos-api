<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

class PlaceholderWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/"\$\$placeholder\$\$"/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(function () use ($matches) {
            return '"(.*?)"';
        });
    }
}
