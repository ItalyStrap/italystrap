<?php namespace ItalyStrap;
/**
 * The footer template file.
 */

/**
 * Global variable for col-x bootstrap class in footer sidebars
 */
global $italystrap_sidebars;
$col = ( isset( $col ) ) ? $col : $italystrap_sidebars->set_col();
?>
<!-- Footer -->
	<footer class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
	<?php do_action( 'footer_open' ); ?>
		<div class="container">
		<?php do_action( 'footer_container_open' ); ?>
			<div class="row" itemscope itemtype="http://schema.org/WPSideBar">

				<?php if ( is_active_sidebar( 'footer-box-1' ) ) : ?>
					<div class="col-md-<?php echo $col; // XSS ok. ?>">
						<?php dynamic_sidebar( 'footer-box-1' ) ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-box-2' ) ) : ?>
					<div class="col-md-<?php echo $col; // XSS ok. ?>">
						<?php dynamic_sidebar( 'footer-box-2' ) ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-box-3' ) ) : ?>
					<div class="col-md-<?php echo $col; // XSS ok. ?>">
						<?php dynamic_sidebar( 'footer-box-3' ) ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-box-4' ) ) : ?>
					<div class="col-md-<?php echo $col; // XSS ok. ?>">
						<?php dynamic_sidebar( 'footer-box-4' ) ?>
					</div>
				<?php endif; ?>
			</div>
		<?php do_action( 'footer_container_closed' ); ?>
		</div>
		<div id="colophon" class="colophon"><!-- #copyright -->
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php
						global $italystrap_theme_mods;
						echo get_the_colophon( $italystrap_theme_mods ); // XSS ok.
						?>
					</div>
				</div>
			</div>
		</div><!-- #copyright -->
	<?php do_action( 'footer_closed' ); ?>
	</footer><!-- #footer -->
<?php do_action( 'wrapper_closed' ); ?>
</div><!-- Wrapper -->
<?php
wp_footer();
do_action( 'body_closed' );
?>
</body>
</html>
