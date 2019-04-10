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

namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag_e, close_tag_e};

\get_header();
\do_action( 'italystrap_before_main' );

    open_tag_e( 'index', 'main' );
        open_tag_e( 'index-container', 'div' );
            open_tag_e( 'index-row', 'div' );

                \do_action( 'italystrap_before_content' );

                open_tag_e( 'content', 'div' );

					\do_action( 'italystrap_before_loop' );

					\do_action( 'italystrap_loop' );

					\do_action( 'italystrap_after_loop' );

                close_tag_e( 'content' );

                \do_action( 'italystrap_after_content' );

            close_tag_e( 'index-row' );
        close_tag_e( 'index-container' );
    close_tag_e( 'index' );

\do_action( 'italystrap_after_main' );
\get_footer();
