<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use ItalyStrap\Components\Brand\CustomLogo;
use ItalyStrap\Event\EventDispatcher;

class CustomLogoTest extends \Codeception\TestCase\WPTestCase {

	/**
	 * @var \WpunitTester
	 */
	protected $tester;
	
	public function setUp(): void {
		// Before...
		parent::setUp();

		// Your set up methods here.
	}

	public function tearDown(): void {
		// Your tear down methods here.

		// Then...
		parent::tearDown();
	}

	private function getInstance(): CustomLogo {
		$sut = new CustomLogo( new EventDispatcher() );
		return $sut;
	}

	/**
	 * @test
	 */
	public function instanceOk() {
		$sut = $this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldRender() {

		/** @var \WP_Post $attachment */
		$attachment = static::factory()->attachment->create_and_get();

		\set_theme_mod('custom_logo', $attachment->ID );

		\add_filter('wp_get_attachment_image_src', function ( $image, int $attachment_id, $size, bool $icon ) {

			$image = [
				\sprintf(
					'%s/wp-content/uploads/image.jpg',
					$_SERVER[ 'TEST_SITE_WP_URL' ]
				),
				100,
				100,
				false
			];

			return $image;
		}, 10, 300);

		$sut = $this->getInstance();
		$custom_logo = $sut->render();


		$this->assertStringContainsString(
			// phpcs:disable
			\sprintf(
				'<a href="%1$s/" class="custom-logo-link navbar-brand" rel="home"><img width="100" height="100" src="%1$s/wp-content/uploads/image.jpg" class="custom-logo " alt="ItalyStrap" /></a>',
				$_SERVER[ 'TEST_SITE_WP_URL' ]
			),
			// phpcs:enable
			$custom_logo,
			''
		);
	}
}
