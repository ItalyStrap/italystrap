<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Site;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Site\Logo;

class LogoTest extends IntegrationTestCase
{
    public function makeInstance(): Logo
    {
        return $this->injector->make(Logo::class);
    }
}
