<?php

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Preview;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;

class PreviewTest extends \Codeception\Test\Unit {


	use BaseUnitTrait;

	protected function getInstance(): Preview {
		$sut = new Preview();
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		\tad\FunctionMockerLe\define('is_preview', static function (): bool {
			return true;
		});

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		\tad\FunctionMockerLe\define('__', static function ( string $text, string $domain) {
			return 'block';
		});
		\tad\FunctionMockerLe\define('wp_kses_post', static function ( string $text ) {
			return 'block';
		});
		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			return 'block';
		});

		$this->expectOutputString('block');
		$sut->display();
	}
}
