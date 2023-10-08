<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Infrastructure;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Infrastructure\ViewBlockTemplatePart;

class ViewBlockTemplatePartTest extends UnitTestCase
{
    public function makeInstance()
    {
        return new ViewBlockTemplatePart();
    }
}
