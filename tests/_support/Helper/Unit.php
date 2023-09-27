<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Fig\EventDispatcher\ParameterDeriverTrait;

class Unit extends \Codeception\Module
{
    use ParameterDeriverTrait;

    public function assertRenderableEventIsChanged(callable $sut, string $expected): void
    {
        $class = $this->getParameterType($sut);
        $event = new $class();

        $this->assertEmpty((string)$event, '');
        $sut($event);
        $this->assertNotEmpty((string)$event, '');
        $this->assertSame($expected, (string)$event, '');
        unset($event, $sut);
    }
}
