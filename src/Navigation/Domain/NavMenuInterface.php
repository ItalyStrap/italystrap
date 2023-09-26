<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\Domain;

interface NavMenuInterface
{
    public function render(array $options = []): string;
}
