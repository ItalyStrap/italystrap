<?php get_header(); ?>
<section>
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<?php get_template_part( 'template/non-trovato');?>
				<p class="text-center"><img src="<?php echo $path ?>/img/404.jpg" alt="Page 404" class="img-rounded"></p>
			</div>
				<?php get_sidebar(); ?> 
		</div>
	</div>
</section>

<?php get_footer(); ?>