<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Title;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;

class TitleTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Title {
		$sut = new Title($this->getConfig());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		\tad\FunctionMockerLe\define('get_post_type', static function () {
			return 'post';
		});

		\tad\FunctionMockerLe\define(
			'post_type_supports',
			static function ( string $post_type, string $feature) {
				Assert::assertEquals('post', $post_type, '');
				return true;
			}
		);

		$this->config->get('post_content_template')->willReturn([]);

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		\tad\FunctionMockerLe\define('is_singular', fn() => false);
		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			return 'block';
		});

		$this->config->get( 'post_thumbnail_size' )->willReturn('post-thumbnail');

		$this->expectOutputString('block');
		$sut->display();
	}
}
