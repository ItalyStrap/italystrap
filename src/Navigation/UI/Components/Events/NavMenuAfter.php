<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

class NavMenuAfter implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
