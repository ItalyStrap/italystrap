<?php

declare(strict_types=1);

namespace ItalyStrap;

?>
<!-- wp:group {"align":"full", "layout":{"inherit":true}} -->
<div class="wp-block-group alignfull">
    <!-- wp:columns -->
    <div class="wp-block-columns">
        <?php foreach ((array)$this->get('footer_sidebars', []) as $value) : ?>
            <?php if (\is_active_sidebar($value)) : ?>
                <!-- wp:column -->
                <div class="wp-block-column">
                    <?php \dynamic_sidebar($value) ?>
                </div>
                <!-- /wp:column -->
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","backgroundColor":"vivid-green-cyan","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-vivid-green-cyan-background-color has-background"><!-- wp:group {"align":"wide","backgroundColor":"pale-cyan-blue","layout":{"type":"flex","orientation":"vertical"}} -->
    <div class="wp-block-group alignwide has-pale-cyan-blue-background-color has-background"><!-- wp:paragraph -->
        <p>Text</p>
        <!-- /wp:paragraph --></div>
    <!-- /wp:group --></div>
<!-- /wp:group -->
