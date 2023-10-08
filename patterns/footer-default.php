<?php

/**
 * Title: Default Footer
 * Slug: italystrap/footer-default
 * Categories: footer
 * Block Types: core/template-part/footer
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Footer\Events\After;
use ItalyStrap\UI\Components\Footer\Events\Before;
use ItalyStrap\UI\Components\Footer\Events\Content;

use function ItalyStrap\Factory\injector;

$dispatcher = injector()->make(\Psr\EventDispatcher\EventDispatcherInterface::class);
?>
<?= $dispatcher->dispatch(new Before()); ?>

<!-- wp:group {"tagName":"footer","className":"site-footer","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<footer class="wp-block-group site-footer">
    <?= $dispatcher->dispatch(new Content()); ?>
</footer>
<!-- /wp:group -->

<?= $dispatcher->dispatch(new After()); ?>
