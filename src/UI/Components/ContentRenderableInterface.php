<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components;

use Psr\EventDispatcher\StoppableEventInterface;
use Stringable;

interface ContentRenderableInterface extends Stringable, StoppableEventInterface
{
}
