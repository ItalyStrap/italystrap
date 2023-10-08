<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Posts\Parts\Title;

/** @var ConfigInterface $this */

?>
<!-- wp:group {"tagName":"header","className":"page-header entry-header","layout":{"inherit":true}} -->
<header class="wp-block-group page-header entry-header">
    <!-- wp:post-title <?= \wp_strip_all_tags((string)$this->get(Title::ATTRIBUTES));?> /-->
</header>
<!-- /wp:group -->
