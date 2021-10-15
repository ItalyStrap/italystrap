<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

// phpcs:disable
require_once $_SERVER['WP_ROOT_FOLDER'] . '/wp-includes/class-wp-walker.php';
require_once $_SERVER['WP_ROOT_FOLDER'] . '/wp-includes/class-walker-nav-menu.php';
// phpcs:enable

use Codeception\Test\Unit;
use ItalyStrap\Tests\BaseUnitTrait;
use \Walker_Nav_Menu;

class WalkerNavMenuTest extends Unit {

	use BaseUnitTrait;

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
	}

	// phpcs:ignore
	protected function _after() {
	}

	protected function getInstance() {
		$sut = new \ItalyStrap\Navbar\BootstrapNavMenu();
		return $sut;
	}
}
