<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Posts\Events\PostContent;
use Psr\EventDispatcher\EventDispatcherInterface;

$dispatcher = $this->get(EventDispatcherInterface::class);

$id = (string)$this->get('id');
$classNames = (string)$this->get('class_names');
?>
<!-- wp:group {"tagName":"article","className":"entry <?= \wp_strip_all_tags($classNames); ?>","layout":{"inherit":true}} -->
<article id="<?= \esc_attr($id); ?>" class="wp-block-group entry <?= \esc_attr($classNames); ?>">
    <?= $dispatcher->dispatch(new PostContent()); ?>
</article>
<!-- /wp:group -->
