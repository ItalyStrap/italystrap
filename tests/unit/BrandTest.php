<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use ItalyStrap\Components\Brand\Logo;

class BrandTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
	}

	protected function _after() {
	}

	private function getInstance(): Logo {
		$sut = new Logo();
		$this->assertInstanceOf( Logo::class, $sut, '' );
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
		$sut = $this->getInstance();
		$html = $sut->render();

		$this->assertNotEmpty( $html, '' );
		$this->assertEquals(
			$html,
			'<a href="site/url" title="title" rel="home"><span>Brand</span></a>',
			''
		);
	}
}
