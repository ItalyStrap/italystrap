<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

require_once $_SERVER['WP_ROOT_FOLDER'] . '/wp-includes/class-wp-walker.php';
require_once $_SERVER['WP_ROOT_FOLDER'] . '/wp-includes/class-walker-nav-menu.php';

use \Walker_Nav_Menu;

class WalkerNavMenuTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
	}

	protected function _after() {
	}

	// tests
	public function testSomeFeature() {
		$walker = new \ItalyStrap\Navbar\BootstrapNavMenu();
//		codecept_debug( $walker );
	}
}
