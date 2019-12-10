<?php 
class ThemeRegisterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
	{
		\tad\FunctionMockerLe\define( 'apply_filters', function ( $filtername, $value ) { return $value; } );
		\tad\FunctionMockerLe\define( 'add_filter', function ( $filtername, $value ) { return $value; } );
		\tad\FunctionMockerLe\define( 'remove_filter', function ( $filtername, $value ) { return $value; } );
//		\tad\FunctionMockerLe\define( 'esc_attr', function ( $value ) { return $value; } );
//		\tad\FunctionMockerLe\define( 'esc_html', function ( $value ) { return $value; } );
	}

    protected function _after()
    {
    }

	private function getInstance() {
    	$event = $this->make( \ItalyStrap\Event\Manager::class
//			[
//				'add_subscriber'	=> function ( $subscriber ) {
//					return true;
//				},
//			]
		);
    	$config = $this->make( \ItalyStrap\Config\Config::class );
		$sut = new \ItalyStrap\Theme\Register( $config, $event );
		$this->assertInstanceOf( \ItalyStrap\Theme\RegisterInterface::class, $sut, '' );
		$this->assertInstanceOf( \ItalyStrap\Theme\Register::class, $sut, '' );
		return $sut;
    }

	/**
	 * @test
	 */
    public function ItShouldBeInstantiable()
    {
    	$sut = $this->getInstance();
    }

	/**
	 * @test
	 */
    public function ItShouldAddRegistrables()
    {
    	$sut = $this->getInstance();

    	$registrable = [];

    	$registrable[] = new class implements \ItalyStrap\Theme\Registrable {

			/**
			 * @inheritDoc
			 */
			public function register() {
				// TODO: Implement register() method.
			}
		};

    	$sut->withRegistrable( ...$registrable );

    	foreach ( $sut->getRegistrables() as $registrable ) {
    		$this->assertInstanceOf( \ItalyStrap\Theme\Registrable::class, $registrable, '' );
		}
    }

	/**
	 * @test
	 */
    public function ItShouldBeBootable()
    {
    	$sut = $this->getInstance();

    	$registrable = [];

    	$registrable[] = new class implements \ItalyStrap\Theme\Registrable {

			/**
			 * @inheritDoc
			 */
			public function register() {
				codecept_debug('Data');
			}

			/**
			 * @inheritDoc
			 */
			public static function get_subscribed_events() {
				return [

				];
			}
		};

    	$sut->withRegistrable( ...$registrable );

//    	$sut->boot();
    }


}