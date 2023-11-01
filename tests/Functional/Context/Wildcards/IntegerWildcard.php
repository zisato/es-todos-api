<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

final class IntegerWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/"\$\$integer\$\$"/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(static function () : string {
            return '\d*?';
        });
    }
}
