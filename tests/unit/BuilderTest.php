<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use tad\FunctionMockerLe;

class BuilderTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var \Prophecy\Prophet
	 */
	private $prophet;

	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $view;

	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $injector;

	/**
	 * @return \ItalyStrap\Empress\Injector
	 */
	public function getInjector(): \ItalyStrap\Empress\Injector {
		return $this->injector->reveal();
	}

	/**
	 * @return \ItalyStrap\View\ViewInterface
	 */
	public function getView(): \ItalyStrap\View\ViewInterface {
		return $this->view->reveal();
	}

	/**
	 * @return \ItalyStrap\Config\ConfigInterface
	 */
	public function getConfig(): \ItalyStrap\Config\ConfigInterface {
		return $this->config->reveal();
	}

	/**
	 * @return \ItalyStrap\Event\EventDispatcherInterface
	 */
	public function getEvent(): \ItalyStrap\Event\EventDispatcherInterface {
		return $this->hooks->reveal();
	}
	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $config;

	/**
	 * @var \Prophecy\Prophecy\ObjectProphecy
	 */
	private $hooks;

	// phpcs:ignore
	protected function _before() {
		$this->prophet = new \Prophecy\Prophet;
		FunctionMockerLe\undefineAll(['__']);
		$this->view = $this->prophet->prophesize( \ItalyStrap\View\ViewInterface::class );
		$this->config = $this->prophet->prophesize( \ItalyStrap\Config\ConfigInterface::class );
		$this->hooks = $this->prophet->prophesize( \ItalyStrap\Event\EventDispatcherInterface::class );
		$this->injector = $this->prophet->prophesize( \ItalyStrap\Empress\Injector::class );
	}

	// phpcs:ignore
	protected function _after() {
	}

	private function getInstance(): \ItalyStrap\Builders\Builder {
		$sut = new \ItalyStrap\Builders\Builder(
			$this->getView(),
			$this->getConfig(),
			$this->getEvent(),
			$this->getInjector()
		);
		$this->assertInstanceOf( \ItalyStrap\Builders\Builder::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$sut = $this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldThrownExceptionIfEventNameIsNotProvided() {
		FunctionMockerLe\define('__', function ( $text ) {
			return $text;
		});

		$this->config->getIterator()->willReturn(new \ArrayIterator([
			'some-component'	=> [
				// event Name not provided
			],
		]));

		$sut = $this->getInstance();
		$sut->setInjector( $this->getInjector() );

		$this->expectException( \RuntimeException::class );
		$sut->build();
	}
}
