<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Footer\Events\Content;
use ItalyStrap\Event\EventDispatcherInterface;

use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\close_tag_e;

/** @var EventDispatcherInterface $globalDispatcher */
$globalDispatcher = $this->get(EventDispatcherInterface::class);

/** @var \Psr\EventDispatcher\EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(\Psr\EventDispatcher\EventDispatcherInterface::class);

$globalDispatcher->trigger('italystrap_before_footer');

open_tag_e('footer', 'footer', [
    'class' => 'site-footer',
]);

echo $dispatcher->dispatch(new Content());

close_tag_e('footer');

$globalDispatcher->trigger('italystrap_after_footer');

close_tag_e('wrapper');

$globalDispatcher->trigger('italystrap_after');

\wp_footer();

close_tag_e('body');
?>
</html>
