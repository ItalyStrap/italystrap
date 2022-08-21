<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Auryn\Injector as AurynInjector;
use Codeception\Test\Unit;
use ItalyStrap\Debug\Injector as DebugInjector;
use ItalyStrap\Empress\Injector as EmpressInjector;
use UnitTester;
use function ItalyStrap\Factory\injector;
use function tad\FunctionMocker\replace;
use function tad\FunctionMocker\setUp;
use function tad\FunctionMocker\tearDown;

final class FactoryInjectorTest extends Unit {

	use UndefinedFunctionDefinitionTrait;

	protected \UnitTester $tester;

	private bool $injector = false;
	private ?int $apply_filters_called = null;

	private ?int $add_filter_called = null;

	private bool $is_debug = false;

	private function resetFilterCountCallState() {
		$this->apply_filters_called = 0;
		$this->add_filter_called = 0;
	}

	// phpcs:ignore
	protected function _before() {
		setUp();

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
	 *
	 */
	public function instanceOkWithFilterFalse() {
		$this->is_debug = false;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		$this->injector = false;
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(1, $this->add_filter_called, 'Add filter should be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 *
	 */
	public function instanceOkWithFilterReturnPrevInstanceOfAuryn() {
		$this->is_debug = false;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		$this->injector = new AurynInjector();
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(0, $this->add_filter_called, 'Add filter should NOT be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertNotInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 *
	 */
	public function instanceOkWithFilterReturnPrevInstanceOfEmpress() {
		$this->is_debug = false;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		$this->injector = new EmpressInjector();
		$injector = injector();

		$this->assertEquals(1, $this->apply_filters_called, 'Apply filters should be called');
		$this->assertEquals(0, $this->add_filter_called, 'Add filter should NOT be called');

		$this->assertInstanceOf( AurynInjector::class, $injector, '' );
		$this->assertInstanceOf( EmpressInjector::class, $injector, '' );
		$this->assertNotInstanceOf( DebugInjector::class, $injector, '' );
	}

	/**
	 *
	 */
	public function assertReturnSameInstance() {
		$this->is_debug = false;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

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
	 *
	 */
	public function debugOk() {
		$this->is_debug = true;
		replace('\ItalyStrap\Core\is_debug', $this->is_debug );

		codecept_debug( (string) is_debug() );

		$injector = injector();
//		$this->assertInstanceOf( DebugInjector::class, $injector, '' );
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
