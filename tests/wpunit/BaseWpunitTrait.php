<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Auryn\Injector;
use ItalyStrap\Config\ConfigInterface;

trait BaseWpunitTrait {

	/**
	 * @var \WpunitTester
	 */
	protected $tester;
	private Injector $injector;
	private ConfigInterface $config;

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$this->getInstance();
	}

	public function setUp(): void {
		// Before...
		parent::setUp();

		$this->injector = \ItalyStrap\Factory\injector();
		$this->config = $this->injector->make(ConfigInterface::class);
		// Your set up methods here.
	}

	public function tearDown(): void {
		// Your tear down methods here.

		// Then...
		parent::tearDown();
	}
}
