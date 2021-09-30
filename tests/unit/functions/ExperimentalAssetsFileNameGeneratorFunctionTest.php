<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Codeception\Test\Unit;
use UnitTester;
use function define;
use function function_exists;
use function Italystrap\Core\experimental_generate_asset_index_filename;

class ExperimentalAssetsFileNameGeneratorFunctionTest extends Unit {

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
		// phpcs:ignore
		\tad\FunctionMockerLe\define('add_filter', function (...$args) {
			return true;
		});

		$genreal_function_file = codecept_absolute_path('functions/asset-helpers.php');

		$this->assertFileExists( $genreal_function_file, "The {$genreal_function_file} file does not exists" );
		require_once $genreal_function_file;

		$this->assertTrue(
			function_exists( '\Italystrap\Core\experimental_generate_asset_index_filename' ),
			'experimental_generate_asset_index_filename function does not exists'
		);
	}

	// phpcs:ignore
	protected function _after() {
	}

	/**
	 * @test
	 */
	public function itShouldReturnOnlyIndexAndCustomWithScriptDebugTrue() {
		if ( ! defined( 'CURRENT_TEMPLATE_SLUG' ) ) {
			define( 'CURRENT_TEMPLATE_SLUG', 'front-page' );
		}

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			define( 'SCRIPT_DEBUG', false );
		}

		$files = experimental_generate_asset_index_filename( 'js' );
		$this->assertIsArray($files, '');
//    	codecept_debug( $files );
	}

	/**
	 * @test
	 */
	public function itShouldReturnOnlyIndexAndCustomWithScriptDebugTruep() {
		if ( ! defined( 'CURRENT_TEMPLATE_SLUG' ) ) {
			define( 'CURRENT_TEMPLATE_SLUG', 'front-page' );
			codecept_debug('RUN');
		}

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			define( 'SCRIPT_DEBUG', true );
		}

		$files = experimental_generate_asset_index_filename( 'js' );
		$this->assertIsArray($files, '');
//    	codecept_debug( $files );
	}
}
