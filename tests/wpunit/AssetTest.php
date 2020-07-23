<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Auryn\InjectionException;
use Codeception\TestCase\WPTestCase;
use ItalyStrap\Asset\Script;
use ItalyStrap\Config\ConfigFactory;
use WpunitTester;
use function add_filter;
use function ItalyStrap\Factory\injector;
use function json_encode;
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
	 * @return mixed
	 * @throws InjectionException
	 */
	private function getInstance( $type ) {
		$config = ConfigFactory::make([]);
		return injector()->make( '\ItalyStrap\Asset\\' . $type, [ ':config' => $config ] );
	}

	/**
	 * @test
	 * style_it should be instantiatable
	 * @throws InjectionException
	 */
	public function instanceOk() {
		$this->assertInstanceOf( '\ItalyStrap\Asset\Style', $this->getInstance( 'Style' ) );
		$this->assertInstanceOf( '\ItalyStrap\Asset\Script', $this->getInstance( 'Script' ) );
	}

	/**
	 * @test
	 * @throws InjectionException
	 * @throws \Auryn\ConfigException
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
			codecept_debug($arg);
			return $arg;
		});

		$sut = injector()->make( Script::class, [ ':config' => $config ] );
		$sut->register_all();

		$this->assertTrue(wp_script_is( 'jquery', 'registered' ), '');
	}
}
