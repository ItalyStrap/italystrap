<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use Psr\EventDispatcher\StoppableEventInterface;
use Stringable;

interface ContentRenderableInterface extends Stringable, StoppableEventInterface
{
}
