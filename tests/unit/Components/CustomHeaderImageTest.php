<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\CustomHeaderImage;
use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Test\Components\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class CustomHeaderImageTest extends \Codeception\Test\Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

	protected function getInstance(): CustomHeaderImage {
		$sut = new CustomHeaderImage($this->getConfig(), $this->getView(), $this->getTag(), $this->getDispatcher());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {

		$this->defineFunction('has_header_image', static fn() => true);

		$sut = $this->getInstance();
		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();

		/** printFigureContainer */
		$this->view->render( 'figure', Argument::type('array') )->willReturn('figure');
		$this->defineFunction('get_header_image_tag', fn() => 'Image tag content');
		$this->config->get(ConfigCustomHeaderProvider::CUSTOM_HEADER_ALIGNMENT)->willReturn('');
		/** end printFigureContainer */

		$this->view->render( 'headers/custom-header', Argument::type('array') )->willReturn('headers/custom-header');

		$this->defineFunction('do_blocks', static function ( string $block ) {
			Assert::assertEquals('headers/custom-header', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
