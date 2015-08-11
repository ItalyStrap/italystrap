<?php
/**
 * The 404 template file.
 */
get_header(); ?>
    <!-- Main Content -->
	<section id="error404">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<?php

                    if ( class_exists('ItalyStrapBreadcrumbs') ) {

                        $defaults = array(
                            'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
                        );

                        new ItalyStrapBreadcrumbs( $defaults );
                    
                    }

					get_template_part( 'loops/content', 'none');
					get_template_part( 'template/sitemap_html');

					?>


					
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</section><!-- / #error404 -->

<?php get_footer(); ?>