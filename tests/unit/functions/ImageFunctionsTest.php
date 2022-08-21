<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Test\UndefinedFunctionDefinitionTrait;
use function ItalyStrap\Image\get_ID_image_from_url;

class ImageFunctionsTest extends \Codeception\Test\Unit {
	use UndefinedFunctionDefinitionTrait;

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
		$this->defineFunction( 'esc_url', fn( string $string ) => $string );
		$this->defineFunction( 'wp_get_attachment_url', fn( $id ) => 'url' );
	}

	/**
	 * @test
	 */
	public function getIDImageFromUrl() {
		global $wpdb;
		$wpdb = new class {

			public $posts;

			// phpcs:ignore
			public function get_var( $arg ) {
			}

			public function prepare( $arg ) {
			}
		};

		$this->defineFunction( 'absint', fn( $val ) => (int) $val );

		get_ID_image_from_url( 'url' );
	}
}
