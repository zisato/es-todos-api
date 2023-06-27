<?php

namespace EsTodosApi\Tests\Functional\Context\Wildcards;

trait WildcardsTrait
{
    private array $wildcards;

    public function __construct()
    {
        $this->wildcards = [
            new IntegerWildcard(),
            new TimestampWildcard(),
            new DateFormatWildcard(),
            new PlaceholderWildcard(),
        ];
    }

    public function replaceWildcards(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $search = ['(', ')', '[', ']', '+', '.'];
        $replace = ['\(', '\)', '\[', '\]', '\+', '\.'];

        $value = str_replace($search, $replace, $value);
        
        return $this->handleWildcards($value);
/*
        $search = ['(', ')', '[', ']', '+', '.'];
        $replace = ['\(', '\)', '\[', '\]', '\+', '\.'];
        
        //$search = ['(', ')', '[', ']', '+', '.', '$$placeholder$$'];
        //$replace = ['\(', '\)', '\[', '\]', '\+', '\.', '(.*?)'];

        return str_replace($search, $replace, $value);
*/
    }

    private function handleWildcards(string $value): string
    {
        /** @var Wildcard $wildcard */
        foreach ($this->wildcards as $wildcard) {
            if (preg_match($wildcard->regex(), $value) > 0) {
                $value = preg_replace_callback(
                    $wildcard->regex(), 
                    function ($matches) use ($wildcard) {
                        $callable = $wildcard->handle($matches);

                        return $callable();
                    },
                    $value
                );
            }
        }

        return $value;
    }
}
