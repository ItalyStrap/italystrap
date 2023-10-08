<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Navigation\UI\Components;

use ItalyStrap\Navigation\UI\Components\Breadcrumbs;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;

class BreadcrumbsTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as itShouldRenderWithViewBlockFromCommonTrait;
    }

    protected function makeInstance(): Breadcrumbs
    {
        $sut = new Breadcrumbs($this->makeGlobalDispatcher(), $this->makeConfig(), $this->makeThemeSupport());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();

        $this->theme_support
            ->has('breadcrumbs')
            ->willReturn(true);

        $this->config->get('current_template_file')->willReturn('template-file');
        $this->config->get('breadcrumbs_show_on', '')->willReturn('template-file');
        $this->config->get('post_content_template')->willReturn([]);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $this->globalDispatcher
            ->trigger('do_breadcrumbs', [])
            ->will(static function () {
                echo 'test';
            });

        $sut = $this->makeInstance();
        $this->tester->assertRenderableEventIsChanged($sut, 'test');
    }
}
