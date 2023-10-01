<?php

declare(strict_types=1);

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Posts\NotFound\Content;

/** @var ConfigInterface $this */

?>
<!-- wp:group {"className":"page-content","layout":{"inherit":true}} -->
<div class="wp-block-group page-content">
    <!-- wp:paragraph {"className":"no-posts"} -->
    <p class="no-posts"><?= \esc_html((string)$this->get(Content::CONTENT, '')); ?></p>
    <!-- /wp:paragraph -->
    <?= (string)$this->get(Content::SEARCH, ''); ?>
</div>
<!-- /wp:group -->
