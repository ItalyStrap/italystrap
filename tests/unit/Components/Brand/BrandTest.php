<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Codeception\Test\Unit;
use ItalyStrap\Components\Brand\CustomLogo;
use ItalyStrap\Components\Brand\Brand;
use ItalyStrap\Config\ConfigInterface;
use Prophecy\Prophecy\ObjectProphecy;
use UnitTester;

class BrandTest extends Unit {

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var ObjectProphecy config
	 */
	private $config;
	/**
	 * @var ObjectProphecy
	 */
	private $custom_logo;

	/**
	 * @return CustomLogo
	 */
	public function getCustomLogo(): CustomLogo {
		return $this->custom_logo->reveal();
	}

	/**
	 * @return ConfigInterface
	 */
	public function getConfig(): ConfigInterface {
		return $this->config->reveal();
	}

	protected function _before() {
		$this->config = $this->prophesize( ConfigInterface::class );
		$this->custom_logo = $this->prophesize( CustomLogo::class );
	}

	protected function _after() {
	}

	private function getInstance(): Brand {
		$sut = new Brand( $this->getConfig(), $this->getCustomLogo() );
		$this->assertInstanceOf( Brand::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function instanceOk() {
		$this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldRenderImageWithBrandLogo() {
		$this->custom_logo->render()->willReturn(
			'<a href="site/url" class="navbar-brand" title="title" rel="home"><span>Brand</span></a>'
		);

		$sut = $this->getInstance();
		$html = $sut->render();

		$this->assertNotEmpty( $html, '' );
		$this->assertEquals(
			$html,
			'<a href="site/url" class="navbar-brand" title="title" rel="home"><span>Brand</span></a>',
			''
		);
	}
}
