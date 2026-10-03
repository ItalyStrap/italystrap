<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Site;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Site\Title;

class TitleTest extends IntegrationTestCase
{
    public function makeInstance(): Title
    {
        return $this->injector->make(Title::class);
    }
}
