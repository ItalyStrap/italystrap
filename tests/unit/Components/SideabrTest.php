<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Sidebar;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class SidebarTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Sidebar {
		$sut = new Sidebar($this->getConfig(), $this->getView());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {

		$this->config->get( 'site_layout' )->willReturn('some-value');

		$sut = $this->getInstance();
		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();

		$this->view->render( 'sidebar', Argument::type('array') )->willReturn('sidebar');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('sidebar', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
