<?php
declare(strict_types=1);

require_once 'BaseTheme.php';
class ThumbnailsTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
//		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$config = \ItalyStrap\Config\ConfigFactory::make( $paramConfig );
		$sut = new \ItalyStrap\Theme\Thumbnails( $config );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\Thumbnails::class, $sut, '' );
		return $sut;
	}


	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$support = [
			'sizes'	=> [
				'navbar-brand-image'	=> [
					\ItalyStrap\Theme\Thumbnails::WIDTH	=> 45,
					\ItalyStrap\Theme\Thumbnails::HEIGHT	=> 45,
					\ItalyStrap\Theme\Thumbnails::CROP		=> true,
				],
			],
		];

		$sut = $this->getInstance( $support );

		$sut->register();

		self::assertTrue( \has_image_size( 'navbar-brand-image' ), '' );
	}
}
