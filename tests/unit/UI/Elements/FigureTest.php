<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Elements;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Elements\Figure;

class FigureTest extends UnitTestCase
{
    public function makeInstance()
    {
        return new Figure(
            $this->makeView(),
            $this->makeTag()
        );
    }
}
