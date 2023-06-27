<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

interface Wildcard
{
    public function regex(): string;

    public function handle(array $matches): \Closure;
}
