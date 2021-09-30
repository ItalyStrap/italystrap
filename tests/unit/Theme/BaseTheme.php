<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Config\ConfigInterface;
use Prophecy\Prophet;

abstract class BaseTheme extends Unit {

	use InstantiableTrait;

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $config;

	/**
	 * @return ConfigInterface
	 */
	public function getConfig(): ConfigInterface {
		return $this->config->reveal();
	}

	// phpcs:ignore
	protected function _before() {
		$this->prophet = new Prophet;
		$this->config = $this->prophet->prophesize( ConfigInterface::class );
	}

	// phpcs:ignore
	protected function _after() {
	}
}
