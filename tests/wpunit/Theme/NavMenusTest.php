<?php
declare(strict_types=1);

class NavMenusTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    
    public function setUp(): void
    {
        // Before...
        parent::setUp();

        // Your set up methods here.
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

	private function getInstance( $paramConfig = [] ) {
    	$config = $this->make( \ItalyStrap\Config\Config::class, $paramConfig );
		$sut = new \ItalyStrap\Theme\NavMenus( $config );
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
