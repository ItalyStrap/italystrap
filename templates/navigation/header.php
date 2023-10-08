<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuHeaderContent;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var \ItalyStrap\Config\ConfigInterface $this */

/** @var GlobalDispatcherInterface $globalDispatcher */
$globalDispatcher = $this->get(GlobalDispatcherInterface::class);

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);
?>
<!-- wp:group {"className":"navbar-header"} -->
<div class="wp-block-group navbar-header">
    <?php $globalDispatcher->trigger('italystrap_navmenu_header'); ?>
    <?= $dispatcher->dispatch(new NavMenuHeaderContent()); ?>
</div>
<!-- /wp:group -->
