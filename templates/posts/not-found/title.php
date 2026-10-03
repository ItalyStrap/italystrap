<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;

/** @var ConfigInterface $this */

?>
<!-- wp:group {"tagName":"header","className":"page-header entry-header","layout":{"inherit":true}} -->
<header class="wp-block-group page-header entry-header">
    <!-- wp:heading {"className":"page-title"} -->
    <h1 class="wp-block-heading page-title"><?= \esc_html((string)$this->get('content')); ?></h1>
    <!-- /wp:heading -->
</header>
<!-- /wp:group -->
