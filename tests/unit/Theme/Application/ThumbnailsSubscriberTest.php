<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Theme\Application;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Application\ThumbnailsSubscriber;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider as Size;
use ItalyStrap\Theme\Infrastructure\ImageSizeInterface;

class ThumbnailsSubscriberTest extends UnitTestCase
{
    // phpcs:ignore
    protected function _before()
    {
        parent::_before();
        $this->defineFunction('set_post_thumbnail_size', static fn(...$args): bool => true);
        $GLOBALS['content_width'] = 750;
    }

    // phpcs:ignore
    protected function _after()
    {
        $this->undefineAllFunction(['set_post_thumbnail_size']);
        unset($GLOBALS['content_width']);
        parent::_after();
    }

    public function testItShouldKeepTheCropPositions(): void
    {
        $sizes = $this->prophet->prophesize(ImageSizeInterface::class);
        $this->config->get(ThumbnailsSubscriber::class, [])->willReturn([
            'centered' => [Size::WIDTH => 300, Size::HEIGHT => 200, Size::CROP => true],
            'top'      => [Size::WIDTH => 750, Size::HEIGHT => 0, Size::CROP => ['center', 'top']],
            'plain'    => [Size::WIDTH => 100],
        ]);

        $sizes->addSize('centered', 300, 200, true)->shouldBeCalledOnce();
        $sizes->addSize('top', 750, 0, ['center', 'top'])->shouldBeCalledOnce();
        $sizes->addSize('plain', 100, 0, false)->shouldBeCalledOnce();

        (new ThumbnailsSubscriber($this->makeConfig(), $sizes->reveal()))();
    }
}
