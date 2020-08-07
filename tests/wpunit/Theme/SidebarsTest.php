<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ArrayIterator;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Theme\Registrable;
use ItalyStrap\Theme\SidebarsSubscriber;
use PHPUnit\Framework\Assert;
use function is_registered_sidebar;

require_once 'BaseTheme.php';
class SidebarsTest extends BaseTheme {

	protected function getInstance() {
		$sut = new SidebarsSubscriber( $this->getConfig(), new Tag( new Attributes() ) );
		$this->assertInstanceOf( Registrable::class, $sut, '' );
		$this->assertInstanceOf( SidebarsSubscriber::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldRegister() {
		$sidebar_id = 'custom-sidebar-for-test';

		$this->config->getIterator()->willReturn( new ArrayIterator(
			[
				[
					'name'				=> __( 'Sidebar', 'italystrap' ),
					'id'				=> $sidebar_id,
					'before_widget'		=> '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
					'after_widget'		=> '</div>',
				]
			]
		) )->shouldBeCalled(1);

		$sut = $this->getInstance();
		$sut->register();

		$this->assertTrue( is_registered_sidebar( $sidebar_id ), '' );
	}

	/**
	 * @test
	 */
	public function ItParseDynamicSidebarBefore() {
		$sidebar_id = 'custom-sidebar-for-test';

		$this->config->getIterator()->willReturn( new ArrayIterator(
			[
				[
					'name'				=> __( 'Sidebar', 'italystrap' ),
					'id'				=> $sidebar_id,
					'before_widget'		=> '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
					'after_widget'		=> '</div>',
				]
			]
		) )->shouldBeCalled(1);

		$sut = $this->getInstance();
		$sut->register();

		global $wp_registered_sidebars;

		$sut->parseDynamicSidebarBefore( $sidebar_id );

		$sidebar = $wp_registered_sidebars[ $sidebar_id ];

		Assert::assertSame('Sidebar', $sidebar['name'], '');
		Assert::assertSame($sidebar_id, $sidebar['id'], '');
		Assert::assertEmpty( $sidebar['description'], '');
		Assert::assertEmpty( $sidebar['class'], '');
		Assert::assertStringContainsString('<div id="%1$s" class="widget %2$s">', $sidebar['before_widget'], '');
		Assert::assertStringContainsString('</div>', $sidebar['after_widget'], '');
		Assert::assertStringContainsString('<h3 class="widgettitle widget-title">', $sidebar['before_title'], '');
		Assert::assertStringContainsString('</h3>', $sidebar['after_title'], '');

	}
}
