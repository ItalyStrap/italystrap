<?php
/**
 * The template part for displaying Colophon
 *
 * @uses get_the_colophon( $theme_mods )
 *
 * @package ItalyStrap
 * @since 4.0.0
 */
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\Core\the_colophon;

?><!-- #copyright -->
<div id="colophon" class="colophon">
	<div class="container">
		<div class="row">
			<div class="col-md-12 colophon-entry-content">
				<?php the_colophon(); // XSS ok.	?>
			</div>
		</div>
	</div>
</div>
<!-- / #copyright -->
