<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation;

interface NavMenuInterface
{
    public function render(array $options = []): string;
}
