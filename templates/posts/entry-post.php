<?php

/**
 * The template part for displaying standard posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Event\EventDispatcherInterface;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);

/** @var int|null $id */
$id = $this->get('id');

/** @var string $class_names */
$class_names = $this->get('class_names');
?>
<article<?php HTML\get_attr_e('entry', [ 'id' => $id, 'class' => $class_names ]) ?>>
<?php
    $dispatcher->dispatch('italystrap_before_entry_content');

        $dispatcher->dispatch('italystrap_entry_content');

    $dispatcher->dispatch('italystrap_after_entry_content');
?>
</article>
