<?php

declare(strict_types=1);

use ItalyStrap\Navigation\UI\Components\Events\NavMenuAfter;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuBefore;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuContent;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var \ItalyStrap\Config\ConfigInterface $config */
$config = $this;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $config->get(EventDispatcherInterface::class);

$context = (string)$config->get(\ItalyStrap\Navigation\UI\Components\MainNavigation::CONTEXT);
?>
<!-- wp:group {"className":"navbar-wrapper none","layout":{"inherit":false}} -->
<div id="main-navbar-container-italystrap-menu-440383729" class="wp-block-group navbar-wrapper none">

    <!-- wp:group {"tagName":"nav","className":"navbar navbar-inverse navbar-static-top"} -->
    <nav class="wp-block-group navbar navbar-inverse navbar-static-top">

        <!-- wp:group {"className":"container"} -->
        <div id="menus-container-440383729" class="wp-block-group container">

            <?= $dispatcher->dispatch(new NavMenuBefore()); ?>

            <!-- wp:group {"className":"navbar-collapse collapse","layout":{"type":"flex","flexWrap":"nowrap"}} -->
            <div id="italystrap-menu-440383729" class="wp-block-group navbar-collapse collapse">
                <?= $dispatcher->dispatch(new NavMenuContent()); ?>
            </div>
            <!-- /wp:group -->

            <?= $dispatcher->dispatch(new NavMenuAfter()); ?>

        </div>
        <!-- /wp:group -->


    </nav>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
