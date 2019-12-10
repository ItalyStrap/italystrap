<?php
declare(strict_types=1);

abstract class BaseTheme extends \Codeception\TestCase\WPTestCase
{
	/**
	 * @var \WpunitTester
	 */
	protected $tester;

	public function setUp(): void
	{
		// Before...
		parent::setUp();

		// Your set up methods here.
	}

	public function tearDown(): void
	{
		// Your tear down methods here.

		// Then...
		parent::tearDown();
	}

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function ItShouldBeInstantiable()
	{
		$this->getInstance();
	}

}