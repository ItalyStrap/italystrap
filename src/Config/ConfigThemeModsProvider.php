<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigThemeModsProvider
{
    private array $theme_mods;

    public function __construct(array $theme_mods)
    {
        $this->theme_mods = $theme_mods;
    }

    public function __invoke(): iterable
    {
        return $this->theme_mods;
    }
}
