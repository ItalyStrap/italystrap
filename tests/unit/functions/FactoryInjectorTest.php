<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Auryn\Injector as AurynInjector;
use Codeception\Test\Unit;
use ItalyStrap\DebugInjector;
use ItalyStrap\Empress\Injector as EmpressInjector;
use UnitTester;
use function ItalyStrap\Factory\injector;
use function tad\FunctionMocker\replace;
use function tad\FunctionMocker\setUp;
use function tad\FunctionMocker\tearDown;

// phpcs:disable
require_once codecept_root_dir() . '/functions/factory.php';
// phpcs:enable

final class FactoryInjectorTest extends Unit {

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var false
	 */
	private $injector = false;
	/**
	 * @var int
	 */
	private $apply_filters_called;

	/**
	 * @var int
	 */
	private $add_filter_called;

	/**
	 * @var bool
	 */
	private $is_debug = false;

	private function resetFilterCountCallState() {
		$this->apply_filters_called = 0;
		$this->add_filter_called = 0;
	}

	// phpcs:ignore
	protected function _before() {
		setUp();

		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		$this->resetFilterCountCallState();

		// phpcs:ignore
		\tad\FunctionMockerLe\define('apply_filters', function ( ...$args ) {
			$this->apply_filters_called++;
			return $this->injector;
		});

		// phpcs:ignore
		\tad\FunctionMockerLe\define('add_filter', function ( ...$args ) {
			$this->add_filter_called++;
			$callable = $args[1];
			$this->injector = $callable();
		});
	}

	// phpcs:ignore
	protected function _after() {
		tearDown();
	}

	/**
	 * @test
	 */
	public function instanceOkWithFilterFalse() {
		$this->injector = false;
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(1, $this->add_filter_called, 'Add filter should be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 * @test
	 */
	public function instanceOkWithFilterReturnPrevInstanceOfAuryn() {
		$this->injector = new AurynInjector();
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(0, $this->add_filter_called, 'Add filter should NOT be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertNotInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 * @test
	 */
	public function instanceOkWithFilterReturnPrevInstanceOfEmpress() {
		$this->injector = new EmpressInjector();
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(0, $this->add_filter_called, 'Add filter should NOT be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 * @test
	 */
	public function assertReturnSameInstance() {
		$injector = injector();
		$another_injector = injector();

		$this->assertSame($injector, $another_injector, 'Should be same instance');
	}

	/**
	 * @test
	 */
//    public function assertReturnSameInstanceewsfew()
//    {
//    	$injector = injector();
//    	$this->injector = new AurynInjector();
//    	$another_injector = injector();
//
//    	$this->assertSame($injector, $another_injector, 'Should be same instance');
//    }

	/**
	 * @test
	 */
	public function debugOk() {
		$this->is_debug = true;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		$injector = injector();
		$this->assertInstanceOf( DebugInjector::class, $injector, '' );
		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(2, $this->add_filter_called, 'Add filter should be called');

		$this->resetFilterCountCallState();
		$another_injector = injector();
		$this->assertInstanceOf( DebugInjector::class, $injector, '' );

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(0, $this->add_filter_called, 'Add filter should NOT be called');

		$this->assertSame($injector, $another_injector, 'Should be same Debug object');
	}

	/**
	 * @TODO Make test for shared and alias Injector
	 */
}
