<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Image\Image;
use function ItalyStrap\Factory\get_config;
use function ItalyStrap\Image\get_the_custom_image_url;
use function ItalyStrap\Image\get_404_image;
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
	public function getCustomImageUrl() {
		$empty = get_the_custom_image_url();
		$this->assertEmpty( $empty );


		$empty_config = get_the_custom_image_url('empty');
		$this->assertEmpty( $empty_config, '' );

		$numeric = get_the_custom_image_url('numeric');
		$this->assertNotEmpty( $numeric, '' );
		$this->assertStringMatchesFormat( 'url', $numeric, '' );

		$int = get_the_custom_image_url('int');
		$this->assertNotEmpty( $int, '' );
		$this->assertStringMatchesFormat( 'url', $numeric, '' );

		$not_empty = get_the_custom_image_url('image_url');
		$this->assertNotEmpty( $not_empty, '' );
		$this->assertStringMatchesFormat( 'value_of_image_url', $not_empty, '' );

		$not_empty = get_the_custom_image_url('no_image_from_user', 'but_image_from_default' );
		$this->assertNotEmpty( $not_empty, '' );
		$this->assertStringMatchesFormat( 'but_image_from_default', $not_empty, '' );
	}

	/**
	 * @test
	 */
	public function get404image() {
		get_404_image();
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
