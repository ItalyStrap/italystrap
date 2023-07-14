<?php

/**
 * The template used for displaying last edit message
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

declare(strict_types=1);

namespace ItalyStrap;

?>
<div class="sr-only screen-reader-text">
    <?php \esc_attr_e('Last edit:', 'italystrap'); ?>&nbsp;
    <time datetime="<?php \the_modified_time('Y-m-d') ?>" itemprop="dateModified">
        <?php \the_modified_time('d F Y') ?>
    </time>
</div>
