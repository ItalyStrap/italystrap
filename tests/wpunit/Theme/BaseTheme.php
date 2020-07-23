<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\TestCase\WPTestCase;

abstract class BaseTheme extends WPTestCase {

	/**
	 * @var \WpunitTester
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

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function instanceOk() {
		$this->getInstance();
	}
}
