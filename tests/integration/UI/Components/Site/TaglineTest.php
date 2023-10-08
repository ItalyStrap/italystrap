<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Site;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Site\Tagline;

class TaglineTest extends IntegrationTestCase
{
    public function makeInstance(): Tagline
    {
        return $this->injector->make(Tagline::class);
    }
}
