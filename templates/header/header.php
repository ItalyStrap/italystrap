<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Header\Events\Content;
use ItalyStrap\Components\Header\Header;
use ItalyStrap\Event\GlobalDispatcherInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

use function ItalyStrap\HTML\open_tag_e;

/** @var GlobalDispatcherInterface $globalDispatcher */
$globalDispatcher = (object)$this->get(GlobalDispatcherInterface::class);

$dispatcher = (object)$this->get(EventDispatcherInterface::class);

/** @var string $body_class */
$body_class = (string)$this->get(Header::BODY_CLASS_NAMES);

/** @var string $wrapper_class */
$wrapper_class = (string)$this->get(Header::WRAPPER_CLASS_NAMES);

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

$globalDispatcher->trigger('italystrap_before');

open_tag_e('wrapper', 'div', [
    'class' => $wrapper_class,
]);

echo $dispatcher->dispatch(new Content());
