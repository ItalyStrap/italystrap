<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Header;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class HeaderTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Header {
		$sut = new Header($this->getConfig(), $this->getView(), $this->getDispatcher());
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

		$this->view->render( 'header', Argument::type('array') )->willReturn('header');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('header', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
