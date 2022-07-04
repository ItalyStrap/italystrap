<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Config\ConfigInterface;
use Prophecy\Prophet;

abstract class BaseTheme extends Unit {

	use BaseUnitTrait;

	// phpcs:ignore
	protected function _before() {
	    $this->setUpProphet();
	}

	// phpcs:ignore
	protected function _after() {
	}
}
