<?php
/**
 * Template Name: Sitemap HTML
 */
get_header(); ?>
    <!-- Main Content -->
    <section id="sitemap-html">
    	<div class="container">
        	<div class="row">
                <div class="col-md-8">
				<?php create_breadcrumbs() ?>
					<div itemscope itemtype="http://schema.org/ItemList">
						<header class="page-header">
							<h1><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark" itemprop="url">
							<span itemprop="name"><?php the_title(); ?></span></a></h1>
						</header>
					<?php get_template_part( 'template/sitemap_html');?>
					<?php get_template_part( 'template/social-button');?>
					</div>
                </div>	
				<?php get_sidebar(); ?> 
            </div>
		</div>
    </section><!-- #content -->
   
<?php get_footer(); ?>