<?php
/**
 * The search template file.
 */
get_header(); ?>
    <!-- Main Content -->
	<section id="search" <?php post_class('class-name'); ?>>
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/SearchResultsPage">
					<?php

                    if ( class_exists('ItalyStrapBreadcrumbs') ) {

                        $defaults = array(
                            'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
                        );

                        new ItalyStrapBreadcrumbs( $defaults );
                    
                    }

					?>
						<header class="page-header">
							<h1 itemprop="headline"><?php printf( __( 'Search result of: %s', 'ItalyStrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header>
					<?php
					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'archive');

						endwhile;
					else : 

						get_template_part( 'loops/content', 'none');

					endif;
					wp_reset_query();
					bootstrap_pagination();
					?>
				</div>
				<?php get_sidebar(); ?> 
			</div>
		</div>
	</section>
<?php get_footer(); ?>