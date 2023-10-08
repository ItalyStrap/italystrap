<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Site;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Site\Title;

class TitleTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as ItShouldRenderFromCommonTrait;
    }

    public function makeInstance(): Title
    {
        return new Title(
            $this->makeView()
        );
    }

    public function testItShouldRenderWithViewBlockFromCommonTrait(): void
    {
        $this->view->render(Title::TEMPLATE_NAME)->willReturn(Title::TEMPLATE_NAME);

        $this->ItShouldRenderFromCommonTrait();
    }
}
