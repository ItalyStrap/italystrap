<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\WPUnit;

use Codeception\TestCase\WPTestCase;

/**
 * @method assertTrue(bool $param)
 */
class ThemeLoaderTest extends WPTestCase
{
    public function testItShouldBeItalystrap()
    {
        $this->assertSame('italystrap', \wp_get_theme()->get_template());
        $this->assertSame('ItalyStrap', \wp_get_theme()->get('Name'));
//      $theme_name = (string)$this->config->get(ConfigThemeProvider::THEME_NAME, '');
//      $this->assertTrue( $theme_name === 'ItalyStrap' );
    }
}
