<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Test\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Theme\Support;
use PHPUnit\Framework\Assert;

class ThemeSupportTest extends Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

	protected function getInstance(): Support {
		$sut = new Support();
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldReturnArray() {

		$sut = $this->getInstance();
		$this->assertIsArray( $sut->toArray(), '' );
	}

	/**
	 * @test
	 */
	public function itShouldAddFeature() {
		$this->defineFunction('add_theme_support', function ( string $feature, ...$args ) {
			Assert::assertStringMatchesFormat('key', $feature, '');
			Assert::assertStringMatchesFormat( 'value', $args[0], '' );
		} );

		$sut = $this->getInstance();
		$sut->add( 'key', 'value' );
	}

	/**
	 * @test
	 */
	public function itShouldRemoveFeature() {
		$this->defineFunction('remove_theme_support', function ( string $feature, ...$args ) {
			Assert::assertStringMatchesFormat('key', $feature, '');
		} );

		$sut = $this->getInstance();
		$sut->remove( 'key' );
	}

	/**
	 * @test
	 */
	public function itShouldGetFeature() {
		$this->defineFunction('get_theme_support', function ( string $feature, ...$args ) {
			Assert::assertStringMatchesFormat('key', $feature, '');
			Assert::assertIsArray($args[0], '');
		} );

		$sut = $this->getInstance();
		$sut->get( 'key', [] );
	}

	/**
	 * @test
	 */
	public function itShouldHasFeature() {
		$this->defineFunction('current_theme_supports', function ( string $feature, ...$args ): bool {
			Assert::assertStringMatchesFormat('key', $feature, '');
			Assert::assertIsArray($args[0], '');
			return true;
		} );

		$sut = $this->getInstance();
		$this->assertTrue( $sut->has( 'key', [] ), '' );
	}
}
