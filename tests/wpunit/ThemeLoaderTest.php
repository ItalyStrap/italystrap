<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\TestCase\WPTestCase;

class ThemeLoaderTest extends WPTestCase {

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
	 * @test
	 */
	public function itShouldBootsrapsFunctionsExists() {

//		codecept_debug( 'CIAO' );
//		codecept_debug( \wp_get_theme()->get_template() );

//		$this->assertTrue( \function_exists( '\ItalyStrap\italystrap' ) );
//		$this->assertTrue( \wp_get_theme()->get_template() === 'italystrap' );
	}
}
