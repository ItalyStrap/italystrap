<?php
/**
 * The template part for displaying Colophon
 *
 * @package ItalyStrap
 * @since 4.0.0
 */
declare(strict_types=1);

namespace ItalyStrap;

use function apply_filters;
use function ItalyStrap\Factory\get_config;
use function wp_kses_post;

?><!-- #copyright -->
<div id="colophon" class="colophon">
	<div class="container">
		<div class="row">
			<div class="col-md-12 colophon-entry-content">
				<?php
				apply_filters(
					'italystrap_colophon_output',
					wp_kses_post( get_config()->get( 'colophon', '' ) )
				); // XSS ok.
				?>
			</div>
		</div>
	</div>
</div>
<!-- / #copyright -->
