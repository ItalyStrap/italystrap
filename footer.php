<?php
/**
 * The footer template file.
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

do_action( 'italystrap_before_footer' );
do_action( 'italystrap_footer' );
do_action( 'italystrap_after_footer' );
?>
	</div><!-- Wrapper -->
<?php
do_action( 'italystrap_after' );
wp_footer(); ?>
</body>
</html>
