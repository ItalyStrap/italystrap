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

/**
 * Global variable for col-x bootstrap class in footer sidebars
 */
global $italystrap_sidebars;
$col = ( isset( $col ) ) ? $col : $italystrap_sidebars->set_col();
?>
<div class="container">
	<div class="row" itemscope itemtype="http://schema.org/WPSideBar">
		<?php foreach ( array( 'footer-box-1', 'footer-box-2', 'footer-box-3', 'footer-box-4' ) as $value ) : ?>

			<?php if ( is_active_sidebar( $value ) ) : ?>
				<div class="col-md-<?php echo $col; // XSS ok. ?>">
					<?php dynamic_sidebar( $value ) ?>
				</div>
			<?php endif; ?>

		<?php endforeach; ?>
	</div>
</div>
