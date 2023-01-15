<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\TestCase\WPTestCase;

abstract class BaseTheme extends WPTestCase {

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$this->getInstance();
	}
}
