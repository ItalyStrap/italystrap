<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

require_once 'BaseTheme.php';
class SupportTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
//		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$config = \ItalyStrap\Config\ConfigFactory::make( $paramConfig );
		$sut = new \ItalyStrap\Theme\Support( $config );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\Support::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$support = [
			'automatic-feed-links',
			'html5'	=> [
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			],
		];

		$sut = $this->getInstance( $support );

		$sut->register();

		$this->assertEqualSets( [$support['html5']], \get_theme_support( 'html5' ) );
	}
}
