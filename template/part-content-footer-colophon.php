<?php
/**
 * The template part for displaying Colophon
 *
 * @uses get_the_colophon( $italystrap_theme_mods )
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

?>
<div id="colophon" class="colophon"><!-- #copyright -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php

				echo apply_filters( 'italystrap_colophon', false );

				global $italystrap_theme_mods;
				echo Core\get_the_colophon( $italystrap_theme_mods ); // XSS ok.
				?>
			</div>
		</div>
	</div>
</div><!-- #copyright -->
