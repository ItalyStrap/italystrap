<?php

declare(strict_types=1);

namespace ItalyStrap;

?>
<!-- wp:group {"tagName":"footer","className":"entry-footer","layout":{"type":"flex"}} -->
<footer class="wp-block-group entry-footer">
    <!-- wp:post-date {"textAlign":"center","isLink":true} /-->

    <!-- wp:post-author {"showAvatar":false} /-->

    <?php if (\comments_open()) : ?>
        <div class="has-text-align-center wp-block-comments-number list-inline-item responses">
            <?php \comments_number(
                \__('No Responses', 'italystrap'),
                \__('One Response', 'italystrap'),
                \__('% Responses', 'italystrap')
            ); ?>
        </div>
    <?php endif; ?>

    <!-- wp:post-terms {"term":"category","textAlign":"center"} /-->

    <!-- wp:post-terms {"term":"post_tag","textAlign":"center"} /-->
</footer>
<!-- /wp:group -->
