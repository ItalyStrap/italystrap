<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Main\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

final class ContentAfter implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
