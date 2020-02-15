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
}
