<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

trait UndefinedFunctionDefinitionTrait
{
    protected function defineFunction(string $function, callable $callback)
    {
        \tad\FunctionMockerLe\define(...func_get_args());
    }
}
