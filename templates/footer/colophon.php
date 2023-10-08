<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\UI\Components\Footer\Colophon;

use function wp_kses_post;

?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group">
        <!-- wp:paragraph -->
        <p><?php echo wp_kses_post((string)$this->get(Colophon::CONTENT, '')); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
