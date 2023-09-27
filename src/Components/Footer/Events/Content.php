<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer\Events;

use ItalyStrap\Components\ContentRenderableEventTrait;
use ItalyStrap\Components\ContentRenderableInterface;

class Content implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
