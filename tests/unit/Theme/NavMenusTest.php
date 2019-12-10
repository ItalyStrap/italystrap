<?php 
class NavMenusTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
		\tad\FunctionMockerLe\define( 'register_nav_menus', function ( $value ) { return $value; } );
    }

    protected function _after()
    {
    }

	private function getInstance( $paramConfig = [] ) {
		$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$sut = new \ItalyStrap\Theme\NavMenus( $config );
		$this->assertInstanceOf( \ItalyStrap\Event\Subscriber_Interface::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\NavMenus::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldBeInstantiable()
	{
		$this->getInstance();
	}

	/**
	 * @test
	 */
	public function ItShouldRegister()
	{
		$sut = $this->getInstance(
			[
				'all'	=> [
					'main-menu'			=> __( 'Main Menu', 'italystrap' ),
				],
			]
		);
		$sut->register();

//		\has_nav_menu( 'main-menu' );
		$this->assertTrue( \has_nav_menu( 'main-menu' ), '' );
	}
}