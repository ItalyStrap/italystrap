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

?><div class="container">
	<div class="row" itemscope itemtype="https://schema.org/WPSideBar">
		<?php foreach ( $this->get( 'footer_sidebars', [] ) as $value ) : ?>

			<?php if ( \is_active_sidebar( $value ) ) : ?>
				<div class="col-md-<?php echo $this->get( 'col' ); // XSS ok. ?>">
					<?php \dynamic_sidebar( $value ) ?>
				</div>
			<?php endif; ?>

		<?php endforeach; ?>
	</div>
</div>
