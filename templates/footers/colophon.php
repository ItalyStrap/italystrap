<?php
/**
 * The template part for displaying Colophon
 *
 * @uses get_the_colophon( $theme_mods )
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

?><!-- #copyright -->
<div id="colophon" class="colophon">
	<div class="container">
		<div class="row">
			<div class="col-md-12 colophon-entry-content">
				<?php

				echo \apply_filters( 'italystrap_colophon', false );

				global $theme_mods;
				echo Core\get_the_colophon( $theme_mods ); // XSS ok.
				?>
			</div>
		</div>
	</div>
</div>
<!-- / #copyright -->
