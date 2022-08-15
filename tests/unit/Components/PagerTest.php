<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Pager;
use ItalyStrap\Test\Components\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class PagerTest extends \Codeception\Test\Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

	protected function getInstance(): Pager {
		$sut = new Pager($this->getConfig(), $this->getView());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		$this->defineFunction('is_single', static fn() => true);

		$this->defineFunction('get_post_type', static function () {
			return 'post';
		});

		$this->defineFunction(
			'post_type_supports',
			static function ( string $post_type, string $feature) {
				Assert::assertEquals('post', $post_type, '');
				return true;
			}
		);

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		$this->defineFunction('do_blocks', static function ( string $block ) {
			return 'block';
		});

		$this->view->render( 'temp/pager', Argument::type('array') )->willReturn('block');
		$this->expectOutputString('block');
		$sut->display();
	}
}
