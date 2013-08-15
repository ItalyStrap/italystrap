<!-- Footer -->
    <footer itemscope itemtype="http://schema.org/WPFooter">
    	<div class="inner">
	    	<div class="container">
	        	<div class="row-fluid" itemscope itemtype="http://schema.org/WPSideBar">
                	<!-- widget -->
		        	<?php 
					if ( ! dynamic_sidebar( 'footer-box-1' ) ) : ?>
					<?php endif; ?>

                    <!-- widget -->
		        	<?php 
					if ( ! dynamic_sidebar( 'footer-box-2' ) ) : ?>
					<?php endif; ?>

					<!-- widget -->
		        	<?php 
					if ( ! dynamic_sidebar( 'footer-box-3' ) ) : ?>
					<?php endif; ?>

		        	<!-- widget -->
                    <?php 
					if ( ! dynamic_sidebar( 'footer-box-4' ) ) : ?>
					<?php endif; ?>
	            </div>
	        </div>
        </div>
	    	<div class="container"><!-- #copyright -->
	        	<div class="row-fluid">
		        	<div class="span12">
						<address></address>
						<p class="muted">&copy; <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> <?php bloginfo('name'); ?> | Developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> | Italystrap version: <span class="badge" itemprop="version">1.0</span>
						</p>
					</div>
                </div>
			</div><!-- #copyright -->

    </footer><!-- #footer -->

	<?php wp_footer(); ?>
	
	<p style="text-align:center;"><?php echo '<br/> <strong>' . get_num_queries() . "</strong> query in <strong>" . timer_stop(1) . "</strong> secondi"; ?></p>

	</body>
</html>
