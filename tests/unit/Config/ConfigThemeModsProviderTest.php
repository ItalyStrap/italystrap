<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Config;

use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class ConfigThemeModsProviderTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): ConfigThemeModsProvider {
		$sut = new ConfigThemeModsProvider([]);
		$this->assertInstanceOf(ConfigThemeModsProvider::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldExecute() {
		$sut = $this->getInstance();
		$sut();
	}
}
