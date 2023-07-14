<?php

/**
 * The main template file.
 *
 * By default, WordPress sets your site’s home page to display your latest blog posts.
 * This page is called the blog posts index.
 * You can also set your blog posts to display on a separate static page.
 * The template file home.php is used to render the blog posts index,
 * whether it is being used as the front page or on separate static page.
 * If home.php does not exist, WordPress will use index.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

declare(strict_types=1);

namespace ItalyStrap;

use function do_action;
use function get_footer;
use function get_header;
use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\close_tag_e;

get_header();
do_action('italystrap_before_main');

?>
<!-- wp:group {"tagName":"main","align":"full","layout":{"inherit":false,"contentSize":"60vw","wideSize":"80vw"}} -->
<main class="wp-block-group">

    <!-- wp:columns {"layout":{"inherit":true}} -->
    <div class="wp-block-columns">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:paragraph {"className":"is-style-blue-quote-ciao"} -->
            <p class="is-style-blue-quote-ciao">jlnblj</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"33%"} -->
        <div class="wp-block-column" style="flex-basis:33%">
            <!-- wp:paragraph {"className":"is-style-blue-quote-ciao"} -->
            <p class="is-style-blue-quote-ciao">kbkb</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->

<?php

        open_tag_e('index-container', 'div');
            open_tag_e('index-row', 'div');

                do_action('italystrap_before_content');

                open_tag_e('content', 'div');

                    do_action('italystrap_before_loop');

                    do_action('italystrap_loop');

                    do_action('italystrap_after_loop');

                close_tag_e('content');

                do_action('italystrap_after_content');
// sidebar
            close_tag_e('index-row');
        close_tag_e('index-container');

?>
</main>
<!-- /wp:group -->
<?php

    do_action('italystrap_after_main');
    get_footer();
