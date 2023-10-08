<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Elements;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Elements\Search;

use function ItalyStrap\Factory\injector;

class SearchTest extends IntegrationTestCase
{
    public function makeInstance()
    {
        return injector()->make(Search::class);
    }
}
