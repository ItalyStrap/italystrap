<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Header;
use ItalyStrap\Event\EventDispatcherInterface;

use function ItalyStrap\HTML\open_tag_e;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);

/** @var string $body_class */
$body_class = $this->get(Header::BODY_CLASS_NAMES);

/** @var string $wrapper_class */
$wrapper_class = $this->get(Header::WRAPPER_CLASS_NAMES);

?><!DOCTYPE html>
<html <?php \language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php \wp_head(); ?>
</head>
<?php
open_tag_e('body', 'body', [
        'class' => $body_class,
]);

\wp_body_open();

$dispatcher->dispatch('italystrap_before');

open_tag_e('wrapper', 'div', [
    'class' => $wrapper_class,
]);

$dispatcher->dispatch('italystrap_before_header');

$dispatcher->dispatch('italystrap_content_header');

$dispatcher->dispatch('italystrap_after_header');
