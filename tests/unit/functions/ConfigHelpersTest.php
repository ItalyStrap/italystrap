<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use function codecept_root_dir;

require_once codecept_root_dir() . '/functions/config-helpers.php';

class ConfigHelpersTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
	}

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
