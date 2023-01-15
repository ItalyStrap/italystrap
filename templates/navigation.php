<?php
declare(strict_types=1);

use ItalyStrap\Event\EventDispatcherInterface;

/** @var \ItalyStrap\Config\ConfigInterface $config */
$config = $this;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $config->get(EventDispatcherInterface::class);

$context = (string)$config->get(\ItalyStrap\Components\MainNavigation::CONTEXT);
?>
<!-- wp:group {"className":"navbar-wrapper none","layout":{"inherit":false}} -->
<div id="main-navbar-container-italystrap-menu-440383729" class="wp-block-group navbar-wrapper none">

	<!-- wp:group {"tagName":"nav","className":"navbar navbar-inverse navbar-static-top"} -->
	<nav class="wp-block-group navbar navbar-inverse navbar-static-top">

		<!-- wp:group {"className":"container"} -->
		<div id="menus-container-440383729" class="wp-block-group container">

			<?php $dispatcher->dispatch('italystrap_before_navmenu'); ?>

			<!-- wp:group {"className":"navbar-collapse collapse","layout":{"type":"flex","flexWrap":"nowrap"}} -->
			<div id="italystrap-menu-440383729" class="wp-block-group navbar-collapse collapse">
				<?php $dispatcher->dispatch('italystrap_navmenu'); ?>
			</div>
			<!-- /wp:group -->

			<?php $dispatcher->dispatch('italystrap_after_navmenu'); ?>

		</div>
		<!-- /wp:group -->


	</nav>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
