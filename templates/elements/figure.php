<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Elements\ElementInterface;

/** @var ConfigInterface $config */
$config = $this;

/** @var Tag $tag */
$tag = $config->get(TagInterface::class);

$context = (string)$config->get(ElementInterface::CONTEXT, __FILE__);
$attributes = (array)$config->get(ElementInterface::ATTR, []);

echo $tag->open($context, 'figure', $attributes);
echo $this->get(ElementInterface::CONTENT, '');
echo $tag->close($context);
