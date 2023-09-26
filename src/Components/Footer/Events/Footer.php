<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer\Events;

use ItalyStrap\Event\PropagationAwareTrait;
use Psr\EventDispatcher\StoppableEventInterface;

class Footer implements \Stringable, StoppableEventInterface
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
