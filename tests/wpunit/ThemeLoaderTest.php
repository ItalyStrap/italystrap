<?php

class ThemeLoaderTest extends \Codeception\TestCase\WPTestCase
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

    // tests
    public function testItShouldBeActiveItalyStrap()
    {
    	$this->assertTrue( function_exists( '\ItalyStrap\italystrap' ) );
    	$this->assertTrue( wp_get_theme()->get_template() === 'italystrap' );
    }

}