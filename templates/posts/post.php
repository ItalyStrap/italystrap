<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Posts\Events\PostContent;
use Psr\EventDispatcher\EventDispatcherInterface;

$dispatcher = $this->get(EventDispatcherInterface::class);

/** @var int|null $id */
$id = $this->get('id');

?>
<article<?php HTML\get_attr_e('entry', [
    'id' => $id,
    'class' => (string)$this->get('class_names')
]) ?>><?= $dispatcher->dispatch(new PostContent()); ?></article>
