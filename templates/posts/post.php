<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Posts\Events\PostContent;
use Psr\EventDispatcher\EventDispatcherInterface;

$dispatcher = $this->get(EventDispatcherInterface::class);

?>
<!-- wp:group
{"tagName":"article","className":"entry","layout":{"inherit":true}}
-->
<article class="wp-block-group entry">
    <?= $dispatcher->dispatch(new PostContent()); ?>
</article>
<!-- /wp:group -->
