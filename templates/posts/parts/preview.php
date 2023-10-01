<?php

declare(strict_types=1);

namespace ItalyStrap;

use function __;

?>
<!-- wp:group {"className":"preview"} -->
<div class="wp-block-group preview">
    <?= \wp_kses_post(__(
        '<strong>Note:</strong> You are previewing this post. This post has not yet been published.',
        'italystrap'
    )); ?>
</div>
<!-- /wp:group -->
