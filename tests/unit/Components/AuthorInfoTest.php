<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\BaseUnitTrait;
use ItalyStrap\View\ViewInterface;
use PHPUnit\Framework\Assert;

class AuthorInfoTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): AuthorInfo {
		$sut = new AuthorInfo($this->getView());
		$this->assertInstanceOf(ViewInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldRender() {
		$sut = $this->getInstance();

		$this->view->render('some-file-name', [])->willReturn('some-content');

		\tad\FunctionMockerLe\define('do_blocks', static function (string $content) {
			Assert::assertEquals('some-content', $content);
			return 'from do_blocks';
		});

		\tad\FunctionMockerLe\define('do_shortcode', static function (string $content) {
			Assert::assertEquals('from do_blocks', $content);
			return 'from do_shortcode';
		});

		$output = $sut->render('some-file-name', []);

		$this->assertEquals('from do_shortcode', $output, '');
	}
}
