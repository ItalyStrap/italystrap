<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigThemeModsProvider
{
    public function __construct(private readonly array $theme_mods)
    {
    }

    public function __invoke(): iterable
    {
        return $this->theme_mods;
    }
}
