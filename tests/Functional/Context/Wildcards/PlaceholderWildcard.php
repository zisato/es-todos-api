<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

final class PlaceholderWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/"\$\$placeholder\$\$"/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(static function () : string {
            return '"(.*?)"';
        });
    }
}
