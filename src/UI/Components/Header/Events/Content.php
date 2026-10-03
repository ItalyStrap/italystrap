<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Header\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

final class Content implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
