<?php
declare(strict_types=1);

require_once 'BaseTheme.php';
class SidebarsTest extends BaseTheme {

	protected function getInstance( $paramConfig = [] ) {
//		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$config = \ItalyStrap\Config\ConfigFactory::make( $paramConfig );
		$sut = new \ItalyStrap\Theme\Sidebars( $config, new \ItalyStrap\HTML\Tag( new \ItalyStrap\HTML\Attributes() ) );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\Sidebars::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$sidebar_id = 'custom-sidebar-for-test';

		$sut = $this->getInstance(
			[
				[
					'name'				=> __( 'Sidebar', 'italystrap' ),
					'id'				=> $sidebar_id,
					'before_widget'		=> '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
					'after_widget'		=> '</div>',
				],
			]
		);

		$sut->register();

		$this->assertTrue( \is_registered_sidebar( $sidebar_id ), '' );


//
//		ob_start();
//		\dynamic_sidebar( $sidebar_id );
//		$sidebar = ob_get_clean();
//
//		codecept_debug( $sidebar );
	}

	/**
	 * @todo Register some widget for displaying the sidebar
	 */
}
