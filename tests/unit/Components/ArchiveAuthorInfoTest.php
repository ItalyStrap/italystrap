<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;

class ArchiveAuthorInfoTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): ArchiveAuthorInfo {
		$sut = new ArchiveAuthorInfo($this->getConfig(), $this->getView());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		\tad\FunctionMockerLe\define('is_author', static function (): bool {
			return true;
		});

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();

		$this->view->render(null, [])->willReturn('some-string');

		$this->expectOutputString('some-string');
		$sut->display();
	}
}
