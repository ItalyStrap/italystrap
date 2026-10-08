<?php

declare(strict_types=1);

namespace ItalyStrap\Block\Application;

use ItalyStrap\Block\Infrastructure\BlockContext;
use ItalyStrap\Block\Infrastructure\TemplateSettings;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;

/**
 * Removes the blocks hidden by the ItalyStrap meta box, as the components do on classic templates.
 *
 * A child theme maps its own blocks to a setting under this class key in the config:
 * [HiddenBlocksSubscriber::class => ['child/featured-image' => 'hide_thumb']]
 */
final class HiddenBlocksSubscriber implements SubscriberInterface
{
    public const SETTINGS = [
        'core/post-title'          => 'hide_title',
        'core/post-content'        => 'hide_content',
        'core/post-featured-image' => 'hide_thumb',
        'core/comments'            => 'hide_comments',
        'core/post-comments-form'  => 'hide_comments_form',
    ];

    private ConfigInterface $config;
    private BlockContext $context;
    private TemplateSettings $settings;

    /**
     * @var array<string, string>|null
     */
    private ?array $map = null;

    public function getSubscribedEvents(): iterable
    {
        yield 'render_block' => [
            self::CALLBACK      => $this,
            self::ACCEPTED_ARGS => 3,
        ];
    }

    public function __construct(ConfigInterface $config, BlockContext $context, TemplateSettings $settings)
    {
        $this->config = $config;
        $this->context = $context;
        $this->settings = $settings;
    }

    /**
     * @param array<string, mixed> $parsedBlock
     */
    public function __invoke(string $content, array $parsedBlock, \WP_Block $block): string
    {
        $setting = $this->map()[$block->name] ?? '';
        if ($setting === '') {
            return $content;
        }

        return $this->isHidden($block, $setting) ? '' : $content;
    }

    /**
     * @return array<string, string>
     */
    private function map(): array
    {
        if ($this->map === null) {
            /** @var array<string, string> $childSettings */
            $childSettings = (array) $this->config->get(self::class, []);
            $this->map = \array_merge(self::SETTINGS, $childSettings);
        }

        return $this->map;
    }

    /**
     * Only the queried post's own settings apply, like the components read them on singular views.
     */
    private function isHidden(\WP_Block $block, string $setting): bool
    {
        $postId = $this->context->postId($block);
        if (!\is_singular() || $postId === 0 || $postId !== \get_queried_object_id()) {
            return false;
        }

        return $this->settings->hides($postId, $setting);
    }
}
