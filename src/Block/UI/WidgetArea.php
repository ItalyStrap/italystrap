<?php

declare(strict_types=1);

namespace ItalyStrap\Block\UI;

use ItalyStrap\Event\SubscriberInterface;

/**
 * The widgets of a sidebar inside a block template, without the column the Sidebar component wraps them in.
 */
final class WidgetArea implements SubscriberInterface
{
    public const NAME = 'italystrap/widget-area';

    public function getSubscribedEvents(): iterable
    {
        yield 'init' => $this;
    }

    public function __invoke(): void
    {
        \register_block_type(self::NAME, [
            'attributes'      => [
                'id' => ['type' => 'string', 'default' => ''],
            ],
            'render_callback' => [$this, 'render'],
        ]);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function render(array $attributes): string
    {
        $id = $attributes['id'] ?? '';
        if (!\is_string($id) || $id === '' || !\is_active_sidebar($id)) {
            return '';
        }

        // dynamic_sidebar() can only echo.
        \ob_start();
        \dynamic_sidebar($id);

        return (string) \ob_get_clean();
    }
}
