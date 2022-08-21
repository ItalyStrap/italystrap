<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\TestCase\WPTestCase;
use ItalyStrap\Config\ConfigThemeProvider;

/**
 * @method assertTrue(bool $param)
 */
class ThemeLoaderTest extends WPTestCase {

	use BaseWpunitTrait;

	public function testItShouldBeItalystrap() {
		$this->assertTrue( \wp_get_theme()->get_template() === 'italystrap' );
		$this->assertTrue( \wp_get_theme()->display('Name') === 'ItalyStrap' );
		$theme_name = (string)$this->config->get(ConfigThemeProvider::THEME_NAME, '');
		$this->assertTrue( $theme_name === 'ItalyStrap' );
	}

	protected function getInstance() {
		// TODO: Implement getInstance() method.
	}
}
