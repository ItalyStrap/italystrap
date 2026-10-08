<?php

declare(strict_types=1);

namespace ItalyStrap\Block\Infrastructure;

/**
 * The "hide" options a post saves through the ItalyStrap meta box.
 */
final class TemplateSettings
{
    private const META_KEY = '_italystrap_template_settings';

    public function hides(int $postId, string $setting): bool
    {
        $settings = \get_post_meta($postId, self::META_KEY, true);

        return \is_array($settings) && \in_array($setting, $settings, true);
    }
}
