<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Main\Events;

use ItalyStrap\Components\ContentRenderableEventTrait;
use ItalyStrap\Components\ContentRenderableInterface;

class Content implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
