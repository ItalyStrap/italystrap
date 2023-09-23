<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\Comments;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

class CommentsTest extends UnitTestCase
{
    protected function getInstance(): Comments
    {
        $sut = new Comments($this->getConfig(), $this->getView(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('is_singular', static fn() => true);

        $this->defineFunction('get_post_type', static fn() => 'post');

        $this->defineFunction(
            'post_type_supports',
            static function (string $post_type, string $feature) {
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
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->view->render('comments')->willReturn('comments');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('comments', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
