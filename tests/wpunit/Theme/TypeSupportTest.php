<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

/**
 * @method static assertArrayHasKey(string $string, array $all_post_type_support, string $string1)
 * @method assertInstanceOf(string $class, \ItalyStrap\Theme\PostTypeSupportSubscriber $sut, string $string)
 */
class TypeSupportTest extends BaseTheme {

	use BaseWpunitTrait;

	protected function getInstance() {
		$sut = new \ItalyStrap\Theme\PostTypeSupportSubscriber( $this->config );
		$this->assertInstanceOf( \ItalyStrap\Theme\PostTypeSupportSubscriber::class, $sut, '' );
		return $sut;
	}

	/**
	 *
	 */
	public function itShouldRegister() {

		$sut = $this->getInstance();

		$sut();

		$all_post_type_support = \get_all_post_type_supports( 'post' );

		self::assertArrayHasKey( 'post_navigation', $all_post_type_support, '' );
		self::assertArrayHasKey( 'entry-meta', $all_post_type_support, '' );
	}
}
