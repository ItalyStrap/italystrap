<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Codeception\Test\Unit;
use Illuminate\Support\Str;
use ItalyStrap\Components\Brand\CustomLogo;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class CustomLogoTest extends Unit {

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var string
	 */
	private $get_custom_logo_return_value = '';

	/**
	 * @var string
	 */
	private $get_image_return_value = '';

	/**
	 * @var ObjectProphecy
	 */
	private $dispatcher;

	/**
	 * @return EventDispatcherInterface
	 */
	public function getDispatcher(): EventDispatcherInterface {
		return $this->dispatcher->reveal();
	}

	// phpcs:ignore
	protected function _before() {
		// phpcs:ignore
		\tad\FunctionMockerLe\define('get_custom_logo', function (): string {
			$image = wp_get_attachment_image(1, 'thumbnail', false, []);

			if ( $image ) {
				$this->get_custom_logo_return_value = $image;
			}

			return $this->get_custom_logo_return_value;
		});

		// phpcs:ignore
		\tad\FunctionMockerLe\define(
			'wp_get_attachment_image',
			function ( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
				return $this->get_image_return_value;
			}
		);

		$this->dispatcher = $this->prophesize( EventDispatcherInterface::class );
	}

	// phpcs:ignore
	protected function _after() {
	}

	private function getInstance(): CustomLogo {
		$sut = new CustomLogo( $this->getDispatcher() );
		return $sut;
	}

	/**
	 * @test
	 */
	public function instanceOk() {
		$sut = $this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldRender() {
		$this
			->dispatcher
			->addListener(
				Argument::type('string'),
				Argument::type('callable'),
				Argument::type('int'),
				Argument::type('int')
			)
			->willReturn(true)
			->shouldBeCalled();

		$this->get_custom_logo_return_value = '<custom-logo>';

		$sut = $this->getInstance();
		$custom_logo = $sut->render();

		$this->assertStringContainsString('<custom-logo>', $custom_logo, '');
	}

	/**
	 * @test
	 */
	public function itShouldAddImageAttributes() {
		$sut = $this->getInstance();
		$sut->withImageAttr( [] );
	}

	public function getCustomLogo( $args ) {
		// phpcs:disable
		$html = \sprintf(
			'<a href="%1$s/" class="custom-logo-link" rel="home"><img width="100" height="100" src="%1$s/wp-content/uploads/image.jpg" class="custom-logo " alt="ItalyStrap" /></a>',
			$_SERVER[ 'TEST_SITE_WP_URL' ]
		);
		// phpcs:enable
		$custom_logo = call_user_func( $args[1], $html, 1 );

		$this->assertStringContainsString('custom-logo-link navbar-brand', $custom_logo, '');
//		$this->assertStringContainsString('rel="home" itemprop="url"', $custom_logo, '');
	}

	public function getCustomLogoImageAttributes( $args ) {
		$custom_logo_attr = [
			'class'	=> 'custom_logo',
		];
		$custom_logo_id = 1;
		$blog_id = 1;

		$img_attr = call_user_func( $args[1], $custom_logo_attr, $custom_logo_id, $blog_id );
		$this->assertIsArray($img_attr, '');
		$this->assertArrayHasKey('class', $img_attr, '');
		$this->assertEquals('custom_logo img-fluid', $img_attr['class'], '');
	}

	/**
	 * @test
	 */
	public function itShouldRenderCustomLogoWithCustomImageAttributes() {
		$unit = $this;

		$this->dispatcher
			->addListener(
				Argument::type('string'),
				Argument::type('callable'),
				Argument::type('int'),
				Argument::type('int')
			)
			->will(function ( $args ) use ( $unit ) {
				$method_name = Str::camel($args[0]);
				if ( ! \method_exists( $unit, $method_name ) ) {
					$unit->fail(\sprintf(
						'Method "%s" does not exist',
						$method_name
					));
				}

				\call_user_func( [ $unit, $method_name ], $args );
			})
			->shouldBeCalledTimes(2);


		$sut = $this->getInstance();

		$sut->withImageAttr( [
			'class'		=> 'img-fluid',
		] );

		$custom_logo = $sut->render();
	}
}
