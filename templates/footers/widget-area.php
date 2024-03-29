<?php
/**
 * @package ItalyStrap
 * @since 4.0.0
 */

declare(strict_types=1);

namespace ItalyStrap;

?>
<!-- wp:group {"layout":{"inherit":true}} -->
<div class="wp-block-group">
	<!-- wp:columns -->
	<div class="wp-block-columns">
		<?php foreach ( $this->get( 'footer_sidebars', [] ) as $value ) : ?>
			<?php if ( \is_active_sidebar( $value ) ) : ?>
				<!-- wp:column -->
				<div class="wp-block-column">
					<?php \dynamic_sidebar( $value ) ?>
				</div>
				<!-- /wp:column -->
			<?php endif; ?>

		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
