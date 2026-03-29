<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Footer\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

final class After implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
