<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Elements;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Elements\Figure;

use function ItalyStrap\Factory\injector;

class FigureTest extends IntegrationTestCase
{
    public function makeInstance()
    {
        return injector()->make(Figure::class);
    }
}
