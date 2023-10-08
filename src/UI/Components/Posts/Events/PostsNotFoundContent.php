<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

class PostsNotFoundContent implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
