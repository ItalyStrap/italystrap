<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Navigation\UI\Components\Breadcrumbs;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;

class BreadcrumbsTest extends UnitTestCase
{
    protected function getInstance(): Breadcrumbs
    {
        $sut = new Breadcrumbs($this->makeGlobalDispatcher(), $this->makeConfig(), $this->makeThemeSupport());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldDisplayBreadcrumbs()
    {

        $args = [];
        $event_name = 'do_breadcrumbs';

        $this->globalDispatcher
            ->trigger('do_breadcrumbs', $args)
            ->will(static function () {
                echo 'test';
            });

        $sut = $this->getInstance();
        $this->expectOutputString('test');
        $sut->display();
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->theme_support
            ->has('breadcrumbs')
            ->willReturn(true);

        $this->config->get('current_template_file')->willReturn('template-file');
        $this->config->get('breadcrumbs_show_on', '')->willReturn('template-file');
        $this->config->get('post_content_template')->willReturn([]);

        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
