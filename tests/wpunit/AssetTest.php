<?php

class AssetTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

	/**
	 * @param $type
	 * @return mixed
	 * @throws \Auryn\InjectionException
	 */
	private function get_instance( $type ) {
		$config = \ItalyStrap\Config\Config_Factory::make([]);
		return \ItalyStrap\Factory\get_injector()->make( '\ItalyStrap\Asset\\' . $type, [ ':config' => $config ] );
    }

    /**
     * @test
     * style_it should be instantiatable
     */
    public function style_it_should_be_instantiatable() {
        $this->assertInstanceOf( '\ItalyStrap\Asset\Style', $this->get_instance( 'Style' ) );
    }

    /**
     * @test
     * script_it should be instantiatable
     */
    public function script_it_should_be_instantiatable() {
        $this->assertInstanceOf( '\ItalyStrap\Asset\Script', $this->get_instance( 'Script' ) );
    }

}