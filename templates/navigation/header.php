<?php

declare(strict_types=1);

use ItalyStrap\Event\EventDispatcherInterface;

/** @var \ItalyStrap\Config\ConfigInterface $config */
$config = $this;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $config->get(EventDispatcherInterface::class);
?>
<!-- wp:group {"className":"navbar-header"} -->
<div class="wp-block-group navbar-header">
    <?php $dispatcher->dispatch('italystrap_navmenu_header'); ?>
</div>
<!-- /wp:group -->
