<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Header\Events\BodyOpened;
use ItalyStrap\UI\Components\Header\Events\Content;
use ItalyStrap\UI\Components\Header\Header;
use Psr\EventDispatcher\EventDispatcherInterface;

use function ItalyStrap\HTML\open_tag_e;

$dispatcher = (object)$this->get(EventDispatcherInterface::class);

?><!DOCTYPE html>
<html <?php \language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php \wp_head(); ?>
</head>
<?php
open_tag_e('body', 'body', [
    'class' => (string)$this->get(Header::BODY_CLASS_NAMES, ''),
]);

\wp_body_open();

echo $dispatcher->dispatch(new BodyOpened());

open_tag_e('wrapper', 'div', [
    'class' => (string)$this->get(Header::WRAPPER_CLASS_NAMES, ''),
]);

echo $dispatcher->dispatch(new Content());
