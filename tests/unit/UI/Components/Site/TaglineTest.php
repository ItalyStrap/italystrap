<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Site;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Site\Tagline;

class TaglineTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as ItShouldRenderFromCommonTrait;
    }

    public function makeInstance(): Tagline
    {
        return new Tagline(
            $this->makeView()
        );
    }

    public function testItShouldRenderWithViewBlockFromCommonTrait(): void
    {
        $this->view->render(Tagline::TEMPLATE_NAME)->willReturn(Tagline::TEMPLATE_NAME);

        $this->ItShouldRenderFromCommonTrait();
    }
}
