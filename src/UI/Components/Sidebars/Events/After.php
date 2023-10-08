<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Sidebars\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

class After implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
