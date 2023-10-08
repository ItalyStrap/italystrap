<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Components\Footer\Events\After;
use ItalyStrap\UI\Components\Footer\Events\Before;
use ItalyStrap\UI\Components\Footer\Events\BodyClosing;
use ItalyStrap\UI\Components\Footer\Events\Content;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);

/** @var TagInterface $tag */
$tag = $this->get(TagInterface::class);

?>
<?= $dispatcher->dispatch(new Before()); ?>

<!-- wp:group {"tagName":"footer","className":"site-footer","layout":{"inherit":true}} -->
<footer class="wp-block-group site-footer">
    <?= $dispatcher->dispatch(new Content()); ?>
</footer>
<!-- /wp:group -->

<?= $dispatcher->dispatch(new After()); ?>
<?php

echo $tag->close('wrapper');

echo $dispatcher->dispatch(new BodyClosing());
