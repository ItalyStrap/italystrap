<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Preview;
use ItalyStrap\Test\UndefinedFunctionDefinitionTrait;

class PreviewTest extends Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

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

		$this->defineFunction('is_preview', static fn(): bool => true);

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		$this->defineFunction('__', static fn(string $text, string $domain) => 'block');
		$this->defineFunction('wp_kses_post', static fn(string $text) => 'block');
		$this->defineFunction('do_blocks', static fn(string $block) => 'block');

		$this->expectOutputString('block');
		$sut->display();
	}
}
