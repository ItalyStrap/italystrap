<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

class ExperimentalAssetsFileNameGeneratorFunctionTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
		\tad\FunctionMockerLe\define('add_filter', function (...$args) {
			return true;
		});

		$genreal_function_file = dirname( __FILE__ ) . '/../../../functions/general-functions.php';

		$this->assertFileExists( $genreal_function_file );
		require_once $genreal_function_file;
	}

	protected function _after() {
	}

	/**
	 * @test
	 */
	public function itShouldReturnOnlyIndexAndCustomWithScriptDebugTrue() {
		if ( ! defined( 'CURRENT_TEMPLATE_SLUG' ) ) {
			\define( 'CURRENT_TEMPLATE_SLUG', 'front-page' );
		}

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			\define( 'SCRIPT_DEBUG', false );
		}

		$files = \Italystrap\Core\experimental_generate_asset_index_filename( 'js' );
		$this->assertIsArray($files, '');
//    	codecept_debug( $files );
	}

	/**
	 * @test
	 */
	public function itShouldReturnOnlyIndexAndCustomWithScriptDebugTruep() {
		if ( ! defined( 'CURRENT_TEMPLATE_SLUG' ) ) {
			\define( 'CURRENT_TEMPLATE_SLUG', 'front-page' );
			codecept_debug('RUN');
		}

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			\define( 'SCRIPT_DEBUG', true );
		}

		$files = \Italystrap\Core\experimental_generate_asset_index_filename( 'js' );
		$this->assertIsArray($files, '');
//    	codecept_debug( $files );
	}
}
