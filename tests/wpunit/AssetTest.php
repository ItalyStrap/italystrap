<?php

class AssetTest extends \Codeception\TestCase\WPTestCase {

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

	/**
	 * @param $type
	 * @return mixed
	 * @throws \Auryn\InjectionException
	 */
	private function get_instance( $type ) {
		$config = \ItalyStrap\Config\Config_Factory::make([]);
		return \ItalyStrap\Factory\injector()->make( '\ItalyStrap\Asset\\' . $type, [ ':config' => $config ] );
	}

	/**
	 * @test
	 * style_it should be instantiatable
	 * @throws \Auryn\InjectionException
	 */
	public function style_it_should_be_instantiatable() {
		$this->assertInstanceOf( '\ItalyStrap\Asset\Style', $this->get_instance( 'Style' ) );
	}

	/**
	 * @test
	 * script_it should be instantiatable
	 * @throws \Auryn\InjectionException
	 */
	public function script_it_should_be_instantiatable() {
		$this->assertInstanceOf( '\ItalyStrap\Asset\Script', $this->get_instance( 'Script' ) );
	}

	public function FilteredAssets() {
		$config = \ItalyStrap\Config\Config_Factory::make([
			'handle'		=> 'jquery',
			'file'			=> '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
			'deps'			=> false,
//				'version'		=> $ver,
			'version'		=> '2.1.1',
			'in_footer'		=> true,
			'pre_register'	=> true,
			'deregister'	=> true, // This will deregister previous registered jQuery.
		]);

		\add_filter('italystrap_config_enqueue_script', function ($arg){
			codecept_debug($arg);
		});

		$sut = \ItalyStrap\Factory\injector()->make( \ItalyStrap\Asset\Script::class, [ ':config' => $config ] );
		$sut->register_all();
		codecept_debug(\json_encode(\wp_script_is( 'jquery', 'registered' )));
	}
}
