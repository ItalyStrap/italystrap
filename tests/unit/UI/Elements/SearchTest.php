<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Elements;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Elements\Search;

class SearchTest extends UnitTestCase
{
    public function makeInstance()
    {
        return new Search(
            $this->makeView(),
            $this->makeTag()
        );
    }
}
