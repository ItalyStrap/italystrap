<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Comments;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class CommentsTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance(): Comments {
		$sut = new Comments($this->getConfig(), $this->getView(), $this->getDispatcher());
		$this->assertInstanceOf(ComponentInterface::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldLoad() {
		$sut = $this->getInstance();

		\tad\FunctionMockerLe\define('is_singular', static function () {
			return true;
		});

		\tad\FunctionMockerLe\define('get_post_type', static function () {
			return 'post';
		});

		\tad\FunctionMockerLe\define(
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

		$this->view->render( 'comments' )->willReturn('comments');

		\tad\FunctionMockerLe\define('do_blocks', static function ( string $block ) {
			Assert::assertEquals('comments', $block, '');
			return 'from do_block';
		});

		$this->expectOutputString('from do_block');
		$sut->display();
	}
}
