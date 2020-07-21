<?php
class StyleTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
		\tad\FunctionMockerLe\define('apply_filters', function (...$arg) {
		});
	}

	protected function _after() {
		\tad\FunctionMockerLe\undefineAll([
			'apply_filters',
		]);
	}

	protected function getInstance() {
		$sut = new \ItalyStrap\Asset\Style( \ItalyStrap\Config\ConfigFactory::make( [] ) );
		$this->assertInstanceOf(\ItalyStrap\Asset\Asset::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function instanceOk() {
		$sut = $this->getInstance();
	}
}
