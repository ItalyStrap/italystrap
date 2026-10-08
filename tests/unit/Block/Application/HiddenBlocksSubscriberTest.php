<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Block\Application;

use ItalyStrap\Block\Application\HiddenBlocksSubscriber;
use ItalyStrap\Block\Infrastructure\BlockContext;
use ItalyStrap\Block\Infrastructure\TemplateSettings;
use ItalyStrap\Tests\UnitTestCase;

class HiddenBlocksSubscriberTest extends UnitTestCase
{
    private const FUNCTIONS = [
        'is_singular',
        'get_queried_object_id',
        'get_the_ID',
        'get_post_meta',
    ];

    /**
     * @var string[]
     */
    private array $hidden = [];

    // phpcs:ignore
    protected function _before()
    {
        parent::_before();
        $this->hidden = [];
        $this->defineFunction('is_singular', static fn(): bool => true);
        $this->defineFunction('get_queried_object_id', static fn(): int => 42);
        $this->defineFunction('get_the_ID', static fn(): int => 42);
        $this->defineFunction('get_post_meta', fn(): array => $this->hidden);
        $this->config->get(HiddenBlocksSubscriber::class, [])->willReturn([]);
    }

    // phpcs:ignore
    protected function _after()
    {
        $this->undefineAllFunction(self::FUNCTIONS);
        parent::_after();
    }

    private function makeInstance(): HiddenBlocksSubscriber
    {
        return new HiddenBlocksSubscriber($this->makeConfig(), new BlockContext(), new TemplateSettings());
    }

    private function makeBlock(string $name, array $context = []): \WP_Block
    {
        $block = new \WP_Block();
        $block->name = $name;
        $block->context = $context;
        return $block;
    }

    public function testItShouldRemoveABlockHiddenByThePostSettings(): void
    {
        $this->hidden = ['hide_title'];

        $content = $this->makeInstance()('<h1>Title</h1>', [], $this->makeBlock('core/post-title'));

        $this->assertSame('', $content);
    }

    public function testItShouldKeepABlockTheSettingsDoNotHide(): void
    {
        $this->hidden = ['hide_content'];

        $content = $this->makeInstance()('<h1>Title</h1>', [], $this->makeBlock('core/post-title'));

        $this->assertSame('<h1>Title</h1>', $content);
    }

    public function testItShouldKeepTheBlocksOfOtherPostsInALoop(): void
    {
        $this->hidden = ['hide_title'];

        $block = $this->makeBlock('core/post-title', ['postId' => 7]);
        $content = $this->makeInstance()('<h1>Title</h1>', [], $block);

        $this->assertSame('<h1>Title</h1>', $content);
    }

    public function testItShouldKeepTheBlocksOutsideSingularViews(): void
    {
        $this->hidden = ['hide_title'];
        $this->undefineFunction('is_singular');
        $this->defineFunction('is_singular', static fn(): bool => false);

        $content = $this->makeInstance()('<h1>Title</h1>', [], $this->makeBlock('core/post-title'));

        $this->assertSame('<h1>Title</h1>', $content);
    }

    public function testItShouldHideTheBlocksAChildThemeMapsInTheConfig(): void
    {
        $this->hidden = ['hide_meta'];
        $this->config->get(HiddenBlocksSubscriber::class, [])->willReturn(['child/entry-meta' => 'hide_meta']);

        $content = $this->makeInstance()('<p>Meta</p>', [], $this->makeBlock('child/entry-meta'));

        $this->assertSame('', $content);
    }
}
