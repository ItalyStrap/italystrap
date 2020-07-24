<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Auryn\InjectionException;
use Codeception\TestCase\WPTestCase;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Config\ConfigFactory;
use WpunitTester;
use function add_filter;
use function ItalyStrap\Factory\injector;
use function wp_script_is;

class AssetTest extends WPTestCase {

	/**
	 * @var WpunitTester
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
	 */
	private function getInstance( $type ) {
		$config = ConfigFactory::make([]);
		return injector()->make( '\ItalyStrap\Asset\\' . $type, [ ':config' => $config ] );
	}

	/**
	 * @test
	 * style_it should be instantiatable
	 */
	public function instanceOk() {
		$this->assertInstanceOf( Style::class, $this->getInstance( 'Style' ) );
		$this->assertInstanceOf( Script::class, $this->getInstance( 'Script' ) );
	}

	/**
	 * @test
	 */
	public function assetShouldBeFiltered() {
		$config = ConfigFactory::make([
			'handle'		=> 'jquery',
			'file'			=> '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
			'deps'			=> false,
			'version'		=> '2.1.1',
			'in_footer'		=> true,
			'pre_register'	=> true,
//			'deregister'	=> true, // This will deregister previous registered jQuery.
		]);

		add_filter('italystrap_config_enqueue_script', function ($arg) {
			$this->assertArrayHasKey( 'handle', $arg, '' );
			$this->assertStringContainsString('jquery', $arg['handle'], '');
			return $arg;
		});

		$sut = new Style($config);

		$sut->register_all();

		$this->assertTrue(wp_script_is( 'jquery', 'registered' ), '');
	}

	/**
	 * @test
	 */
//	public function assetShouldBeFilteredhdhfh() {
//
//		\add_action('after_setup_theme', function (){
//			codecept_debug('CODECEPTION');
//		});
//
//		\add_filter('italystrap_config_enqueue_script', function ($arg) {
//			codecept_debug($arg);
//			return $arg;
//		});
//
//	}
}
