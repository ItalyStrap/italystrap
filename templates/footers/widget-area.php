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

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

// $col = $this->set_col();

?><div class="container">
	<div class="row" itemscope itemtype="https://schema.org/WPSideBar">
		<?php foreach ( $this->footer_sidebars as $value ) : ?>

			<?php if ( is_active_sidebar( $value ) ) : ?>
				<div class="col-md-<?php echo $this->col; // XSS ok. ?>">
					<?php dynamic_sidebar( $value ) ?>
				</div>
			<?php endif; ?>

		<?php endforeach; ?>
	</div>
</div>
