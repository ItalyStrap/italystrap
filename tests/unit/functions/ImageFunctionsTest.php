<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use function ItalyStrap\Factory\get_config;
use function ItalyStrap\Image\get_ID_image_from_url;

// phpcs:disable
require_once codecept_root_dir() . '/functions/images.php';
// phpcs:enable

class ImageFunctionsTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
		$config = get_config();
		$config->merge([
			'image_url'		=> 'value_of_image_url',
			'numeric'	=> '1',
			'int'		=> '1',
		]);

		\tad\FunctionMockerLe\define( 'esc_url', fn( string $string ) => $string );
		\tad\FunctionMockerLe\define( 'wp_get_attachment_url', fn( $id ) => 'url' );
	}

	protected function _after() {
	}

	/**
	 * @test
	 */
	public function getIDImageFromUrl() {
		global $wpdb;
		$wpdb = new class {

			public $posts;

			public function get_var( $arg ) {
			}

			public function prepare( $arg ) {
			}
		};

		\tad\FunctionMockerLe\define( 'absint', fn( $val ) => (int) $val );

		get_ID_image_from_url( 'url' );
	}
}
