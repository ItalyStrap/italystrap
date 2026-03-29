<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\NotFound;

use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\NotFound\Image;
use ItalyStrap\UI\Elements\Figure;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ImageTest extends UnitTestCase
{
    protected function getInstance(): Image
    {
        $sut = new Image(
            $this->makeConfig(),
            $this->makeView(),
            $this->makeGlobalDispatcher(),
            $this->makeTag(),
            new Figure($this->makeView(), $this->makeTag())
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $this->config->get(ConfigNotFoundProvider::ID_IMAGE, 0)->willReturn(10);

        $sut = $this->getInstance();
        $this->defineFunction('is_404', fn() => true);
        $this->config->get(ConfigNotFoundProvider::SHOW_IMAGE, '')->willReturn('show');

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {

        $this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT)->willReturn('align');
        $this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE)->willReturn('thumb-size');
        $this->config->get(ConfigNotFoundProvider::ID_IMAGE, 0)->willReturn(10);

        $sut = $this->getInstance();

        $this->defineFunction('wp_get_attachment_image', function (
            $attachment_id,
            $size = 'thumbnail',
            $icon = false,
            $attr = ''
        ): string {
            Assert::assertSame(10, $attachment_id, '');
            Assert::assertSame('thumb-size', $size, '');
            Assert::assertIsArray($attr, '');

            return 'From wp_get_attachment_image';
        });

        $this->view->render('figure', Argument::type('array'))->willReturn('figure');

//        $this->tester->assertRenderableEventIsChanged($sut, 'figure');

//        $this->expectOutputString('figure');
//        $sut->display();
    }
}
