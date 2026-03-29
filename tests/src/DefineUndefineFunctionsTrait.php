<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

trait DefineUndefineFunctionsTrait
{
    protected function defineFunction(string $function, callable $callback): void
    {
        \tad\FunctionMockerLe\define($function, $callback);
    }

    protected function undefineFunction(string $function): void
    {
        \tad\FunctionMockerLe\undefine($function);
    }

    protected function undefineAllFunction(array $functions): void
    {
        \tad\FunctionMockerLe\undefineAll($functions);
    }
}
