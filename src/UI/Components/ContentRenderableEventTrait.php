<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components;

use ItalyStrap\Event\PropagationAwareTrait;

trait ContentRenderableEventTrait
{
    use PropagationAwareTrait;

    private string $content = '';

    public function appendContent(string $content): void
    {
        $this->content .= $content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
