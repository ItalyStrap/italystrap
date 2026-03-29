<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class ThemeLoaderTest extends IntegrationTestCase
{
    public function testConfigExistsAndHasAllConfig()
    {
        $this->assertInstanceOf(ConfigInterface::class, $this->config);
        $this->assertIsArray($this->config->all());
        $this->assertNotEmpty($this->config->all());
    }

    public function testItShouldBeItalystrap()
    {
        $this->assertSame('italystrap', \wp_get_theme()->get_template());
        $this->assertSame('ItalyStrap', \wp_get_theme()->get('Name'));
        $theme_name = (string)$this->config->get(ConfigThemeProvider::THEME_NAME, '');
        $this->assertTrue($theme_name === 'ItalyStrap');
    }
}
