<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

require_once 'BaseTheme.php';
class ThumbnailsTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
//		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$config = \ItalyStrap\Config\ConfigFactory::make( $paramConfig );
		$sut = new \ItalyStrap\Theme\ThumbnailsSubscriber( $config );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\ThumbnailsSubscriber::class, $sut, '' );
		return $sut;
	}


	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$support = [
			'sizes'	=> [
				'navbar-brand-image'	=> [
					\ItalyStrap\Theme\ThumbnailsSubscriber::WIDTH	=> 45,
					\ItalyStrap\Theme\ThumbnailsSubscriber::HEIGHT	=> 45,
					\ItalyStrap\Theme\ThumbnailsSubscriber::CROP		=> true,
				],
			],
		];

		$sut = $this->getInstance( $support );

		$sut->register();

		self::assertTrue( \has_image_size( 'navbar-brand-image' ), '' );
	}
}
