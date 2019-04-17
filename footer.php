<?php
/**
 * The footer template file.
 */

namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag_e, close_tag_e};

\do_action( 'italystrap_before_footer' );

    open_tag_e( 'footer', 'footer' );

		\do_action( 'italystrap_footer' );

    close_tag_e( 'footer' );

\do_action( 'italystrap_after_footer' );

close_tag_e( 'wrapper' );

\do_action( 'italystrap_after' );

\wp_footer();

close_tag_e( 'body' );
?>
</html>
