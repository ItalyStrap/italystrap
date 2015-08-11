<?php
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
	<footer itemscope itemtype="http://schema.org/WPFooter">
	<?php do_action( 'footer_open' ); ?>
			<div class="container">
			<hr>
			<?php do_action( 'footer_container_open' ); ?>
				<div class="row" itemscope itemtype="http://schema.org/WPSideBar">

					<?php if ( is_active_sidebar( 'footer-box-1' ) ) : ?>
						<div class="col-md-<?php echo $col; ?>">
							<?php dynamic_sidebar( 'footer-box-1' ) ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-box-2' ) ) : ?>
						<div class="col-md-<?php echo $col; ?>">
							<?php dynamic_sidebar( 'footer-box-2' ) ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-box-3' ) ) : ?>
						<div class="col-md-<?php echo $col; ?>">
							<?php dynamic_sidebar( 'footer-box-3' ) ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-box-4' ) ) : ?>
						<div class="col-md-<?php echo $col; ?>">
							<?php dynamic_sidebar( 'footer-box-4' ) ?>
						</div>
					<?php endif; ?>
				</div>
			<?php do_action( 'footer_container_closed' ); ?>
			</div>
			<div id="colophon" class="container"><!-- #copyright -->
				<hr>
				<div class="row">
					<div class="col-md-12">
						<p class="text-muted small">&copy; <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> <?php echo esc_attr( GET_BLOGINFO_NAME ); ?> | This website uses <?php echo wp_get_theme()->get('Name'); ?> powered by <a href="http://www.italystrap.it" rel="nofollow" itemprop="url">ItalyStrap</a> developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> <?php if ( !is_child_theme() ): ?>| Theme version: <span class="badge" itemprop="version"><?php italystrap_version(); ?></span><?php endif; ?>
						</p>
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