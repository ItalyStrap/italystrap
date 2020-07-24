<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\AssetsManagerOld;
use ItalyStrap\Asset\ScriptOld;
use ItalyStrap\Asset\StyleOld;

class AssetsManagerTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $style;

	/**
	 * @return StyleOld
	 */
	public function getStyle(): StyleOld {
		return $this->style->reveal();
	}

	/**
	 * @return ScriptOld
	 */
	public function getScript(): ScriptOld {
		return $this->script->reveal();
	}
	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $script;

	protected function _before() {
		$this->style = $this->prophesize( StyleOld::class );
		$this->script = $this->prophesize( ScriptOld::class );
	}

	protected function _after() {
	}

	protected function getInstance(): AssetsManagerOld {
		$sut = new AssetsManagerOld();
		$this->assertInstanceOf( AssetsManagerOld::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldBeInstantiable() {
		$this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldRegister() {
		$sut = $this->getInstance();
		$sut->withAssets(
			$this->getStyle(),
			$this->getStyle(),
			$this->getStyle(),
			$this->getStyle(),
			$this->getScript()
		);
		$sut->register();
	}
}
