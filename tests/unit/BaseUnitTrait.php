<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Components\Headers\CustomHeader;
use ItalyStrap\Components\Navigations\Navbar;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Theme\Support as ThemeSupport;
use Prophecy\Prophet;

trait BaseUnitTrait {

	/** @var \UnitTester  */
	protected $tester;

	private \Prophecy\Prophet $prophet;

	private \Prophecy\Prophecy\ObjectProphecy $config;

	public function getConfig(): ConfigInterface {
		return $this->config->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $dispatcher;

	public function getDispatcher(): \ItalyStrap\Event\EventDispatcherInterface {
		return $this->dispatcher->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $view;

	public function getView(): \ItalyStrap\View\ViewInterface {
		return $this->view->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $injector;

	public function getInjector(): \ItalyStrap\Empress\Injector {
		return $this->injector->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $finder;

	public function getFinder(): \ItalyStrap\Finder\FinderInterface {
		return $this->finder->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $theme_support;

	public function getThemeSupport(): ThemeSupport {
		return $this->theme_support->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $navbar;

	public function getNavbar(): Navbar {
		return $this->navbar->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $custom_header;

	public function getCustomHeader(): CustomHeader {
		return $this->custom_header->reveal();
	}

	private \Prophecy\Prophecy\ObjectProphecy $tag;

	public function getTag(): Tag {
		return $this->tag->reveal();
	}

	// phpcs:ignore
	protected function _before() {
		$this->setUpProphet();
	}

	// phpcs:ignore
	protected function _after() {
		$this->tearDownProphet();
	}

	private function setUpProphet() {
		$this->prophet = new Prophet;
		$this->config = $this->prophet->prophesize( ConfigInterface::class );
		$this->view = $this->prophet->prophesize( \ItalyStrap\View\ViewInterface::class );
		$this->dispatcher = $this->prophet->prophesize( \ItalyStrap\Event\EventDispatcherInterface::class );
		$this->injector = $this->prophet->prophesize( \ItalyStrap\Empress\Injector::class );
		$this->finder = $this->prophet->prophesize( \ItalyStrap\Finder\FinderInterface::class );
		$this->theme_support = $this->prophet->prophesize( ThemeSupport::class );
		$this->navbar = $this->prophet->prophesize(Navbar::class);
		$this->custom_header = $this->prophet->prophesize(CustomHeader::class);
		$this->tag = $this->prophet->prophesize(Tag::class);
	}

	private function tearDownProphet() {
		$this->prophet->checkPredictions();
	}

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$sut = $this->getInstance();
	}
}
