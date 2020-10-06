<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use function codecept_root_dir;

// phpcs:disable
require_once codecept_root_dir() . '/functions/config-helpers.php';
// phpcs:enable

class ConfigHelpersTest extends \Codeception\Test\Unit {

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

	/**
	 * @test
	 */
	public function getConfigFileContent() {
//		$config = \ItalyStrap\Config\get_config_file_content( 'default' );
//		codecept_debug($config);
	}
}
