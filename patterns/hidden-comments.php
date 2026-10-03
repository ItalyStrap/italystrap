<?php

/**
 * Title: Hidden Comments
 * Slug: italystrap/hidden-comments
 * Inserter: no
 */

?>
<!-- wp:comments -->
<div class="wp-block-comments">

    <!-- wp:comments-title {"level":3} /-->

    <!-- wp:comment-template -->

    <!-- wp:columns {"isStackedOnMobile":false} -->
    <div class="wp-block-columns is-not-stacked-on-mobile">

        <!-- wp:column {"width":"clamp(48px, 17.917vw - 3.125rem, 96px)"} -->
        <div class="wp-block-column" style="flex-basis:clamp(48px, 17.917vw - 3.125rem, 96px)">
            <!-- wp:avatar {"className":"img-fluid"} /-->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">

            <!-- wp:group {"layout":{"type":"flex"}} -->
            <div class="wp-block-group">

                <!-- wp:comment-author-name /-->

                <!-- wp:comment-date {"format":"j M Y"} /-->

                <!-- wp:comment-edit-link /-->

                <!-- wp:comment-reply-link /-->

            </div>
            <!-- /wp:group -->

            <!-- wp:comment-content /-->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

    <!-- /wp:comment-template -->

    <!-- wp:comments-pagination -->
    <!-- wp:comments-pagination-previous /-->

    <!-- wp:comments-pagination-numbers /-->

    <!-- wp:comments-pagination-next /-->
    <!-- /wp:comments-pagination -->

    <!-- wp:pattern {"slug":"italystrap/hidden-post-comments-form"} /-->

</div>
<!-- /wp:comments -->
