<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Main\Events;

use ItalyStrap\Components\ContentRenderableEventTrait;
use ItalyStrap\Components\ContentRenderableInterface;

class Index implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
