<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Finder\FinderInterface;
use function ItalyStrap\Config\config_files_finder;
use function ItalyStrap\Config\get_config_file_content;
use function ItalyStrap\Config\get_config_file_content_last;

require_once \codecept_root_dir() . 'functions/config-helpers.php';

class ConfigHelpersTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {

		$_data = \codecept_data_dir( 'fixtures/config' );

		\tad\FunctionMockerLe\define( 'get_stylesheet_directory', fn() => $_data . '/child-theme' );
		\tad\FunctionMockerLe\define( 'get_template_directory', fn() => $_data . '/parent-theme' );
	}

	// phpcs:ignore
	protected function _after() {
	}

	/**
	 * @test
	 */
	public function itShouldReturnFinderObject() {
		$sut = config_files_finder();
		$this->assertInstanceOf( FinderInterface::class, $sut, '' );
	}

	/**
	 * @test
	 */
	public function getConfigFileContent() {
		$config = get_config_file_content( 'default' );
		$this->assertArrayHasKey( 'from-parent', $config, '' );
		$this->assertEquals([
			'from-parent'	=> 'override by child',
		], $config, '');
	}

	/**
	 * @test
	 */
	public function getConfigFileContentLast() {
		$config = get_config_file_content_last( 'default' );
		$this->assertArrayHasKey( 'from-parent', $config, '' );
		$this->assertEquals([
			'from-parent'	=> 'override by child',
		], $config, '');
	}
}
