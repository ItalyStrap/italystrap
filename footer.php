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
			</div>
			<div id="colophon" class="container"><!-- #copyright -->
				<hr>
				<div class="row">
					<div class="col-md-12">
						<p class="text-muted small">&copy; <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> <?php echo esc_attr( GET_BLOGINFO_NAME ); ?> | Theme developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> | Theme name: <a href="http://www.italystrap.it" rel="nofollow" itemprop="url">ItalyStrap</a> <?php if ( !is_child_theme() ): ?>| Theme version: <span class="badge" itemprop="version"><?php italystrap_version(); ?></span><?php endif; ?>
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