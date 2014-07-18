<?php get_header(); ?>
<section id="error404">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php get_template_part( 'template/non-trovato');?>
				<?php get_template_part( 'template/sitemap_html');?>
			</div>
				<?php get_sidebar(); ?> 
		</div>
	</div>
</section>

<?php get_footer(); ?>