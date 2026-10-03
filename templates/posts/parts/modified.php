<?php

declare(strict_types=1);

namespace ItalyStrap;

?>
<!-- wp:group {"className":"sr-only screen-reader-text","layout":{"inherit":true}} -->
<div class="wp-block-group sr-only screen-reader-text">
    <?php \esc_attr_e('Last edit:', 'italystrap'); ?>&nbsp;
    <time datetime="<?= \get_the_modified_time('Y-m-d') ?>">
        <?= \get_the_modified_time('d F Y') ?>
    </time>
</div>
<!-- /wp:group -->
