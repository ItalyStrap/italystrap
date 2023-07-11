<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

class Support
{
    public function toArray(): array
    {
        global $_wp_theme_features;
        return $_wp_theme_features ?? [];
    }

    /**
     * @param mixed ...$args
     * @return false|null
     */
    public function add(string $feature, ...$args): ?bool
    {
        return \add_theme_support(...func_get_args());
    }

    public function remove(string $feature): ?bool
    {
        return \remove_theme_support($feature);
    }

    /**
     * @param mixed ...$args
     * @return false|mixed
     */
    public function get(string $feature, ...$args)
    {
        return \get_theme_support(...func_get_args());
    }

    /**
     * @param string $feature
     * @param mixed ...$args
     * @return bool
     */
    public function has(string $feature, ...$args): bool
    {
        return \current_theme_supports(...func_get_args());
    }
}
