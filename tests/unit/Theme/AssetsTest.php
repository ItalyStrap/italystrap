<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Theme\Assets;
use ItalyStrap\Theme\Registrable;

require_once 'BaseTheme.php';

class AssetsTest extends BaseTheme {

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

	protected function getInstance(): Assets {
		$sut = new Assets();
		$this->assertInstanceOf( Registrable::class, $sut, '');
		return $sut;
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
