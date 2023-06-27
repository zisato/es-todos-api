<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

class DateFormatWildcard implements Wildcard
{
    public function regex(): string
    {
        return '/\"?\$\$date_format:([^\$\$]+),([^\$\$]+),([^\$\$]+)\$\$\"?/';
    }

    public function handle(array $matches): \Closure
    {
        return \Closure::fromCallable(function () use ($matches) {
            $date = (new \DateTime($matches[1]))->format($matches[2]);

            settype($date, $matches[3]);

            return $date;
        });
    }
}
