<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\FeaturedImage;
use ItalyStrap\Test\Components\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;

class FeaturedImageTest extends \Codeception\Test\Unit {

	use BaseUnitTrait, UndefinedFunctionDefinitionTrait;

	protected function getInstance(): FeaturedImage {
		$sut = new FeaturedImage($this->getConfig(), $this->getView());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		$this->defineFunction('get_post_type', static function () {
			return 'post';
		});

		$this->defineFunction(
			'post_type_supports',
			static function ( string $post_type, string $feature) {
				Assert::assertEquals('post', $post_type, '');
				return true;
			}
		);

		$this->config->get('post_content_template')->willReturn([]);

		$this->assertTrue($sut->shouldDisplay(), '');
	}

	/**
	 * @test
	 */
	public function itShouldDisplay() {
		$sut = $this->getInstance();
		$this->defineFunction('is_singular', fn() => false);

		$this->config->get( 'site_layout' )->willReturn('full_width');
//		$this->defineFunction('is_page_template', static function ( string $template ) {
//			Assert::assertSame('full-width.php', $template, '');
//			return 'full-width';
//		});

		$this->defineFunction('do_blocks', static function ( string $block ) {
			return 'block';
		});

		$this->config->get( 'post_thumbnail_size' )->willReturn('post-thumbnail');

		$this->expectOutputString('block');
		$sut->display();
	}
}
