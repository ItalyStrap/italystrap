<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Config;

use ItalyStrap\Config\ConfigMiscProvider;
use ItalyStrap\Test\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class ConfigMiscProviderTest extends \Codeception\Test\Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

	protected function getInstance(): ConfigMiscProvider {
		$sut = new ConfigMiscProvider($this->getConfig());
		$this->assertInstanceOf(ConfigMiscProvider::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldExecute() {
		$sut = $this->getInstance();

		$this->defineFunction('esc_attr__', fn() => '');
		$this->defineFunction('apply_filters', fn(...$args) => '');

		$sut();
	}
}
