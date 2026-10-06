<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

class NavMenuBefore implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
