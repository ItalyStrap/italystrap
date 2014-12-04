<?php
/**
 * The footer template file.
 */
?>
<!-- Footer -->
    <footer itemscope itemtype="http://schema.org/WPFooter">
	    	<div class="container">
				<hr>
	        	<div class="row" itemscope itemtype="http://schema.org/WPSideBar">
                	<!-- widget -->
		        	<?php if ( ! dynamic_sidebar( 'footer-box-1' ) ) : ?>
					<?php endif; ?>

                    <!-- widget -->
		        	<?php if ( ! dynamic_sidebar( 'footer-box-2' ) ) : ?>
					<?php endif; ?>

					<!-- widget -->
		        	<?php if ( ! dynamic_sidebar( 'footer-box-3' ) ) : ?>
					<?php endif; ?>

		        	<!-- widget -->
                    <?php if ( ! dynamic_sidebar( 'footer-box-4' ) ) : ?>
					<?php endif; ?>
	            </div>
	        </div>
	    	<div class="container"><!-- #copyright -->
				<hr>
	        	<div class="row">
		        	<div class="col-md-12">
						<p class="text-muted small">&copy; <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> <?php bloginfo('name'); ?> | Developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> | Theme name: <a href="http://www.italystrap.it" rel="nofollow" itemprop="url">ItalyStrap</a> <?php if ( !is_child_theme() ): ?>| Theme version: <span class="badge" itemprop="version"><?php italystrap_version(); ?></span><?php endif; ?>
						</p>
					</div>
                </div>
			</div><!-- #copyright -->

    </footer><!-- #footer -->
</div><!-- Wrapper -->
	<?php wp_footer(); ?>
	<?php if( !is_preview() && !is_admin() ) : ?>  
	<!-- Google Analytics Code  --> 
	<?php endif; ?>
</body>
</html>