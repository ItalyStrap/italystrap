<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\TestCase\WPTestCase;
use ItalyStrap\Config\ConfigInterface;
use Prophecy\Prophet;
use WpunitTester;

abstract class BaseTheme extends WPTestCase {

	/**
	 * @var WpunitTester
	 */
	protected $tester;

	protected $config;

	/**
	 * @return ConfigInterface
	 */
	public function getConfig(): ConfigInterface {
		return $this->config->reveal();
	}

	public function setUp(): void {
		// Before...
		parent::setUp();

		$this->prophet = new Prophet;

		// Your set up methods here.
		$this->config = $this->prophet->prophesize( ConfigInterface::class );
	}

	public function tearDown(): void {
		// Your tear down methods here.

		// Then...
		parent::tearDown();
	}

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$this->getInstance();
	}
}
