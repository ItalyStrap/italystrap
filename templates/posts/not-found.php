<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFoundContent;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var $this ConfigInterface */

/** @var $dispatcher EventDispatcherInterface */
$dispatcher = (object)$this->get(EventDispatcherInterface::class);

?>
<!-- wp:group {"tagName":"section","className":"no-results not-found","layout":{"inherit":true}} -->
<section id="posts-not-found" class="wp-block-group no-results not-found">
    <?= $dispatcher->dispatch(new PostsNotFoundContent()); ?>
</section>
<!-- /wp:group -->
