<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Sidebars\Events\After;
use ItalyStrap\UI\Components\Sidebars\Events\Before;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = (object)$this->get(EventDispatcherInterface::class);
?>

<?= $dispatcher->dispatch(new Before()); ?>
<!-- wp:column {"width":"33.33%","className":"sidebar"} -->
<div class="wp-block-column sidebar" style="flex-basis:33.33%">
    <?php \dynamic_sidebar((string)$this->get('index')) ?>
</div>
<!-- /wp:column -->
<?= $dispatcher->dispatch(new After()); ?>
