<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\CustomHeaderImage;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class CustomHeaderImageTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): CustomHeaderImage {
		$sut = new CustomHeaderImage($this->getConfig(), $this->getView(), $this->getCustomHeader());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {

		\tad\FunctionMockerLe\define('has_header_image', static function () {
			return true;
		});

		$sut = $this->getInstance();
		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();

		$this->view->render( 'headers/custom-header', Argument::type('array') )->willReturn('headers/custom-header');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('headers/custom-header', $block, '');
			return 'from do_block';
		});

		$this->custom_header->getData()->willReturn([]);

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
