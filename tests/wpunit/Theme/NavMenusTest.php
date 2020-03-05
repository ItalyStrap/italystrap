<?php
declare(strict_types=1);

require_once 'BaseTheme.php';

class NavMenusTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$sut = new \ItalyStrap\Theme\NavMenus( $config );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\NavMenus::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldRegister() {
		\add_filter( 'theme_mod_nav_menu_locations', function ( $default ) {
			return [
				'new-menu'			=> __( 'Main Menu', 'italystrap' ),
			];
		} );

		$sut = $this->getInstance(
			[
				'all'	=> [
					'new-menu'			=> __( 'Main Menu', 'italystrap' ),
				],
			]
		);

		$sut->register();

		$this->assertTrue( \has_nav_menu( 'new-menu' ), '' );
	}
}
