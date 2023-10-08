<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Components\Header\Events\BodyOpened;
use ItalyStrap\UI\Components\Header\Events\Content;
use ItalyStrap\UI\Components\Header\Header;
use Psr\EventDispatcher\EventDispatcherInterface;

$dispatcher = (object)$this->get(EventDispatcherInterface::class);
$tag = (object)$this->get(TagInterface::class);

echo $dispatcher->dispatch(new BodyOpened());

echo $tag->open('wrapper', 'div', [
    'class' => (string)$this->get(Header::WRAPPER_CLASS_NAMES, ''),
]);

echo $dispatcher->dispatch(new Content());
