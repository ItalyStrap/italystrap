<?php

declare(strict_types=1);

namespace ItalyStrap\Headers;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Header\CustomHeaderImage;

/**
 * @var $this ConfigInterface
 */

?>
<!-- wp:group {"tagName":"header","className":"site-header","layout":{"inherit":true}} -->
<header class="wp-block-group site-header">
    <?= \strip_tags((string)$this->get(CustomHeaderImage::CONTENT), ['img', 'figure']); ?>
</header>
<!-- /wp:group -->
