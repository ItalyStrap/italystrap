<?php
/**
 * The footer template file.
 */

namespace ItalyStrap;

do_action( 'italystrap_before_footer' );

	?><footer <?php HTML\get_attr( 'footer', [], true ); ?>><?php

		do_action( 'italystrap_footer' );

	?></footer><?php

do_action( 'italystrap_after_footer' );

	?></div><!-- Wrapper -->
<?php
do_action( 'italystrap_after' );
wp_footer(); ?>
</body>
</html>
