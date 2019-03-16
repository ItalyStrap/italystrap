<?php

class ThemeLoaderTest extends \Codeception\TestCase\WPTestCase
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

    // tests
    public function testItShouldBeActiveItalyStrap()
    {
    	$this->assertTrue( function_exists( '\ItalyStrap\italystrap' ) );
    	$this->assertTrue( wp_get_theme()->get_template() === 'italystrap' );
    }

}