<!-- Footer -->
    <footer itemscope itemtype="http://schema.org/WPFooter">
	    	<div class="container">
				<hr>
	        	<div class="row" itemscope itemtype="http://schema.org/WPSideBar">
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
	    	<div class="container"><!-- #copyright -->
				<hr>
	        	<div class="row">
		        	<div class="col-md-12">
						<p class="text-muted">&copy; <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> <?php bloginfo('name'); ?> | Developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> | Italystrap version: <span class="badge" itemprop="version">1.5.1</span>
						</p>
					</div>
                </div>
			</div><!-- #copyright -->

    </footer><!-- #footer -->

	<?php wp_footer(); ?>
	<script>
      !function ($) {
        $(function(){
          // carousel demo
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    </script>
	</body>
</html>
