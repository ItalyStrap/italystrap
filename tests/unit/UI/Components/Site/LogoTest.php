<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Site;

use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeSupportProvider;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Components\Site\Logo;

class LogoTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as ItShouldRenderFromCommonTrait;
    }

    public function makeInstance(): Logo
    {
        return new Logo(
            $this->makeConfig(),
            $this->makeView(),
            $this->makeThemeSupport(),
            new Json()
        );
    }

    public function testItShouldDisplay()
    {
        $sut = $this->makeInstance();

        $this->theme_support->has(ConfigThemeSupportProvider::CUSTOM_LOGO)->willReturn(true);
        $this->config->get(ConfigSiteLogoProvider::CUSTOM_LOGO_ID)->willReturn(1);

        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
