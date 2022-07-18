<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Colophon;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ColophonTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Colophon {
		$sut = new Colophon($this->getConfig(), $this->getView(), $this->getDispatcher());
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

		$this->config->get( 'colophon', '' )->willReturn('footers/colophon');

		$this->dispatcher->filter(
			'italystrap_colophon_output',
			'footers/colophon'
		)->shouldBeCalled();

		$this->view->render( 'footers/colophon', Argument::type('array') )->willReturn('footers/colophon');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('footers/colophon', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
