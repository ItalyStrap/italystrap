<?php
/**
 * The footer template file.
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}
?><footer <?php Core\get_attr( 'footer', array( 'class' => 'site-footer', 'itemscope' => true, 'itemtype' => 'http://schema.org/WPFooter' ), true ); ?>><?php

do_action( 'italystrap_before_footer' );
do_action( 'italystrap_footer' );
do_action( 'italystrap_after_footer' );

?></footer>
	</div><!-- Wrapper -->
<?php
do_action( 'italystrap_after' );
wp_footer(); ?>
</body>
</html>
