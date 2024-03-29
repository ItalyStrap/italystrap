<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Footer;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class FooterTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Footer {
		$sut = new Footer($this->getConfig(), $this->getView(), $this->getDispatcher());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();
		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		$expected_output = 'footer';

		$this->view->render( 'footer', Argument::type('array') )->willReturn($expected_output);

		$this->expectOutputString($expected_output);
		$sut->display();
	}
}
