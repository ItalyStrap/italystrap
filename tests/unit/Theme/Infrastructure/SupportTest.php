<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Theme\Infrastructure;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Support;

class SupportTest extends UnitTestCase
{
    protected function getInstance(): Support
    {
        $sut = new Support();
        return $sut;
    }

    // tests
    public function instanceOk()
    {
        $this->getInstance();
    }
}
