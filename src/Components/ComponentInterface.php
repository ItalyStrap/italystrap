<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

interface ComponentInterface
{
    public const DISPLAY_METHOD_NAME = 'display';

    public function shouldDisplay(): bool;

    public function display(): void;
}
