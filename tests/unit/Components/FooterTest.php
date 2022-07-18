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

		$this->view->render( 'footer', Argument::type('array') )->willReturn('footer');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('footer', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
