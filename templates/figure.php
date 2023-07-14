<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML\Tag;

/** @var ConfigInterface $config */
$config = $this;

/** @var Tag $tag */
$tag = $config->get(Tag::class);

$context = (string)$config->get('context', __FILE__);
$attributes = (array)$config->get('figureAttributes', []);

echo $tag->open($context, 'figure', $attributes);
echo $this->get('content');
echo $tag->close($context);
