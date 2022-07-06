<?php
declare(strict_types=1);

namespace ItalyStrap\Test\Components;

use ItalyStrap\Components\Breadcrumbs;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\BaseUnitTrait;

class BreadcrumbsTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function _before() {
		$this->setUpProphet();
	}

	protected function getInstance(): Breadcrumbs {
		$sut = new Breadcrumbs($this->getDispatcher(), $this->getConfig(), $this->getThemeSupport());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldDisplayBreadcrumbs() {

		$args = [];
		$event_name = 'do_breadcrumbs';

		$this->dispatcher
			->dispatch('do_breadcrumbs', $args)
			->will(static function () {
				echo 'test';
			});

		$sut = $this->getInstance();
		$this->expectOutputString('test');
		$sut->display();
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		$this->theme_support
			->has('breadcrumbs')
			->willReturn(true);

		$this->config->get('current_template_file')->willReturn('template-file');
		$this->config->get( 'breadcrumbs_show_on', '' )->willReturn('template-file');
		$this->config->get( 'post_content_template' )->willReturn([]);

		$this->assertTrue($sut->shouldDisplay(), '');
	}
}
