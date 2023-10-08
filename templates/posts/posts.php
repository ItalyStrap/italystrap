<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Posts\Events\PostsContent;
use ItalyStrap\UI\Components\Posts\Events\PostsContentAfter;
use ItalyStrap\UI\Components\Posts\Events\PostsContentBefore;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFound;
use Psr\EventDispatcher\EventDispatcherInterface;

$dispatcher = $this->get(EventDispatcherInterface::class);

if (! \have_posts()) {
    echo $dispatcher->dispatch(new PostsNotFound());
    return;
}

//echo $dispatcher->dispatch(new PostsContentBefore());
//
//while (\have_posts()) {
//    \the_post();
//
//    echo $dispatcher->dispatch(new PostsContent());
//}
//
//echo $dispatcher->dispatch(new PostsContentAfter());

?>
<?= $dispatcher->dispatch(new PostsContentBefore()); ?>
<!-- wp:query {"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true}} -->
<div class="wp-block-query">
    <!-- wp:post-template -->
    <?= $dispatcher->dispatch(new PostsContent()); ?>
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?= $dispatcher->dispatch(new PostsContentAfter()); ?>

