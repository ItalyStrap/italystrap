<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

trait BaseUnitTrait {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
	}

	// phpcs:ignore
	protected function _after() {
	}

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$sut = $this->getInstance();
//		if ( ! $sut ) {
//			$this->fail( 'Create an instance' );
//		}
	}
}
