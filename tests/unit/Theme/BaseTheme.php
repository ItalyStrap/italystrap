<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;

abstract class BaseTheme extends Unit {

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
		$this->getInstance();
	}
}
