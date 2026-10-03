<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Events;

use ItalyStrap\UI\Components\ContentRenderableEventTrait;
use ItalyStrap\UI\Components\ContentRenderableInterface;

final class PostsNotFound implements ContentRenderableInterface
{
    use ContentRenderableEventTrait;
}
