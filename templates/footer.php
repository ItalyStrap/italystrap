<?php

/**
 * The footer template file.
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Event\EventDispatcherInterface;

use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\close_tag_e;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);

$dispatcher->dispatch('italystrap_before_footer');

open_tag_e('footer', 'footer', [
    'class' => 'site-footer',
]);

$dispatcher->dispatch('italystrap_footer');

close_tag_e('footer');

$dispatcher->dispatch('italystrap_after_footer');

close_tag_e('wrapper');

$dispatcher->dispatch('italystrap_after');

\wp_footer();

close_tag_e('body');
?>
</html>
