<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

require_once 'BaseTheme.php';
class TypeSupportTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
//		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$config = \ItalyStrap\Config\ConfigFactory::make( $paramConfig );
		$sut = new \ItalyStrap\Theme\PostTypeSupportSubscriber( $config );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\PostTypeSupportSubscriber::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$support = 	[
			'post'		=> [ 'post_navigation', 'entry-meta' ],
			'page'		=> [ 'post_navigation', 'entry-meta' ],
			'download'	=> [ 'post_navigation', 'entry-meta' ],
		];

		$sut = $this->getInstance( $support );

		$sut->register();

		$all_post_type_support = \get_all_post_type_supports( 'post' );

		self::assertArrayHasKey( 'post_navigation', $all_post_type_support, '' );
		self::assertArrayHasKey( 'entry-meta', $all_post_type_support, '' );
	}
}
