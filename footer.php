<?php
/**
 * The footer template file.
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

do_action( 'italystrap_before_footer' );

	?><footer <?php Core\get_attr( 'footer', array( 'class' => 'site-footer', 'itemscope' => true, 'itemtype' => 'https://schema.org/WPFooter' ), true ); ?>><?php

		do_action( 'italystrap_footer' );

	?></footer><?php

do_action( 'italystrap_after_footer' );

	?></div><!-- Wrapper -->
<?php
do_action( 'italystrap_after' );
wp_footer(); ?>
</body>
</html>
