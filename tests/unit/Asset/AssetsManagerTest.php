<?php

use ItalyStrap\Asset\AssetsManager;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Theme\Registrable;

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
	 * @return Style
	 */
	public function getStyle(): Style {
		return $this->style->reveal();
	}

	/**
	 * @return Script
	 */
	public function getScript(): Script {
		return $this->script->reveal();
	}
	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $script;

	protected function _before() {
		$this->style = $this->prophesize( Style::class );
		$this->script = $this->prophesize( Script::class );
	}

	protected function _after() {
	}

	protected function getInstance(): AssetsManager {
		$sut = new AssetsManager();
		$this->assertInstanceOf( AssetsManager::class, $sut, '');
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
