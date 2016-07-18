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

<?php do_action( 'wrapper_closed' ); ?>
</div><!-- Wrapper -->
<?php
wp_footer();
do_action( 'body_closed' );
?>
</body>
</html>
